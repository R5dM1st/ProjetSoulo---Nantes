#!/bin/bash

# Installation de PostgreSQL
# if not already installed
if ! [ -x "$(command -v psql)" ]; then
  apt-get update
  apt-get install -y postgresql
fi

# Installation d'Apache2
if ! [ -x "$(command -v apache2)" ]; then
  apt-get update
  apt-get install -y apache2
fi

# installion de php
if ! [ -x "$(command -v php)" ]; then
  apt-get update
  apt-get install -y php libapache2-mod-php php-pgsql
fi

# Création d'un utilisateur et d'un mot de passe
sudo -u postgres psql -c "CREATE USER groupe3 WITH PASSWORD '1234';"

# Importation des bases de données et des tables depuis le fichier main.sql
CREATE DATABASE ma_nouvelle_base;



# sudo -i -u postgres
