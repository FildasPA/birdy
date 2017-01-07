#!/bin/bash
#==============================================================================
#
# ■ Configure le dépôt local
# -- Objet : Indique à Git d'ignorer ou de suivre les modifications locales
#            des fichiers de configuration.
# -- Usage : ./localhost.sh [-n --no]
# -- Par : Julien Boge
# -- Dernière modification : 07.01.17
#
#==============================================================================

assume='--assume-unchanged'
CONFIG_FILES=(
              'lib/core/dbconnection.log.php'
              'birdy/model/_tables.infos.php'
)
#------------------------------------------------------------------------------
# * Print help
#------------------------------------------------------------------------------
print_help()
{
	printf "\
Usage : ./setup.sh [options]

Indique à Git d'ignorer ou de suivre les modifications locales des fichiers
de configuration.

Options :
   -h, --help              Affiche ce message d'aide
   -n, --no, --no-assume   De nouveau suivre les modifications
"
}

#------------------------------------------------------------------------------
# * Handle command line arguments
#------------------------------------------------------------------------------
handle_options()
{
	options=`getopt -o hn --long help,no,no-assume -- "$@"`
	eval set -- "$options"

	while true ; do
	  case "$1" in
			-h | --help )              print_help   ; exit 0 ;;
			-n | --no | --no-assume )  assume='--no-assume-unchanged' ; shift ;;
			-- )                       shift ; break ;;
			* )                        printf "Erreur" ; exit 1 ;;
	  esac
	done
}

#------------------------------------------------------------------------------
# * Main
#------------------------------------------------------------------------------
main()
{
	handle_options "$@"

	if [[ "$assume" == "--assume-unchanged" ]]; then
		printf "Git now assume these files are unchanged :\n"
	else
		printf "Git is now tracking these files :\n"
	fi

	for file in "${CONFIG_FILES[@]}" ; do
		printf "  $file\n"
		git update-index $assume "$file"
	done
}

main "$@"
