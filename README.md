# eo-framework-starter

## Getting Started

### Prérequis

* NodeJS
* NPM
* WordPress
* Gulp

Récupérer ce dépôt avec la commande suivante:

```bash
git clone https://github.com/Eoxia/eo-framework-starter plugin-name && cd plugin-name && rm -rf .git && git init && git submodule add https://github.com/Eoxia/eo-framework core/external/eo-framework
```

Installer [NodeJS](https://nodejs.org/en/) puis ouvrir une console sur votre dossier "plugin-name" puis faites la commande suivante:

```bash
npm install -g gulp && npm install && npm start
```

Cette dernière commande permet de gérer les fichiers **CSS** (ou SCSS) et **JS**.

## La structure de eo-framework-starter

Image | Description
----- | -----------
![Image de la structure du starter](https://github.com/Eoxia/eo-framework-starter/blob/master/core/asset/image/structure_plugin.PNG) | La structure sur l'image *ci-contre* est celle que nous venons de télécharger.<br /><br />Nous avons les deux dossiers principaux "core" et "module". Nous considérons le dossier "core" comme un *module*.<br /><br />Nous utilisons la notion de **module** pour séparer les différentes fonctionnalités de nos plugins.<br />Nous avons également comme principe de séparer nos fonctions de nos fichiers selon leurs thèmes<br /><br />Les **actions** se trouverons dans le dossier 'action'<br />Les **classes** sont dans le dossier 'class'<br />Les **vues** sont dans le dossier 'view'<br />Les **assets** sont dans le dossier 'assets' (Ce dossier contient les ressources du module: JS, CSS, Image et autre types de ressources...)<br />Les **filtres** sont dans le dossier 'filtres'<br />Les **shortcodes** sont dans le dossier 'shortcodes'<br /><br />Tout module doit **obligatoirement** contenir un fichier *nom_du_module*.config.json. Sinon celui-ci ne sera pas initialisé par EO-Framework.

## Les fichiers starter.php et starter.config.json

Le fichier principal lu par WordPress: **starter.php**
```php
<?php
/*
Plugin Name:  EO Framework Starter
Plugin URI:   https://github.com/Eoxia/eo-framework-starter
Description:  Un plugin WordPress utilisant EO-Framework.
Version:      0.1.0
Author:       Eoxia
Author URI:   https://eoxia.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  eo-starter-domain
Domain Path:  /languages
*/

/** Des defines utiles pour inclure votre CSS, JS et fichier MO **/
DEFINE( 'PLUGIN_NOM_PLUGIN_PATH', realpath( plugin_dir_path( __FILE__ ) ) . '/' );
DEFINE( 'PLUGIN_NOM_PLUGIN_URL', plugins_url( basename( __DIR__ ) ) . '/' );
DEFINE( 'PLUGIN_NOM_PLUGIN_DIR', basename( __DIR__ ) );

/** Ligne supplémentaire pour utiliser eo-framework **/
require_once( 'core/external/eo-framework/eo-framework.php' );

/** Boot votre plugin; Nous reviendrons sur cette ligne dans les prochains chapitres. **/
\eoxia\Init_Util::g()->exec( PLUGIN_NOM_PLUGIN_PATH, basename( __FILE__, '.php' ) );
```

Ce fichier contient: 
* Les "headers" obligatoire pour déclarer  un plugin WordPress.
* Trois "DEFINE" qui permettent des actions utiles dans vos modules.
	* **PLUGIN_NOM_PLUGIN_PATH**: Le chemin absolue vers votre plugin.
	* **PLUGIN_NOM_PLUGIN_URL**: L'url complet vers votre plugin.
	* **PLUGIN_NOM_PLUGIN_DIR**: Le chemin absolue vers votre plugin sans le nom du fichier starter.php.
* La ligne *require_once* permet d'inclure EO-Framework.
* La dernière ligne permet de lancer le boot du plugin avec EO-Framework.

Le fichier principal de config: **starter.config.json**
```json
{
	"name": "Starter",
	"slug": "starter",
	"modules": [
		"core/core.config.json",
		"module/hello-world/hello_world.config.json"
	],
	"version": "0.1.0"
}
```

Le fichier JSON est obligatoire pour initialisé le plugin avec EO-Framework. Le slug doit obligatoirement correspondre au nom du fichier **boot** de *WordPress*.

Ensuite le tableau "modules" permet de **communiquer** à EO-Framework les modules à initialiser lors du boot du plugin.

## Le dossier core

Ce dossier est un traité comme un **module** par EO-Framework, il vas d'abord lire le fichier core.config.json pour ensuite nitialiser les fichiers requis par le module (dependencies).

```json
{
	"name": "Test Core",
	"slug": "core",
	"version": "0.1.0",
	"description": "Les fichiers core du plugin",
	"path": "core/",
	"dependencies": {
		"action": {}
	}
}
```

Ce fichier est différent de starter.config.json, car c'est un fichier config.json d'un **module** à la différence du config.json principale de l'application (cf starter.config.json).

* Le **slug** doit être le nom du fichier lui même.
* Le **path** est obligatoire et c'est un chemin à partir du **dossier principale** du plugin.
* La clé **"dependencies"** permet de définir les fichiers à inclure dans le module. Dans notre cas tous les fichiers dans le dossier "action" du module "Test Core" sera inclus.

### Le fichier action principal: core.action.php

Ce fichier inclus les styles et scripts principales de l'application; il est important de comprendre comment GULP gère les assets:

EO-Framework marche avec **GULP** pour minifier automatiquement vos styles et vos scripts.

GULP vas assembler et minifier tous les fichiers JS portant comme extension \*.backend.js pour ensuite sortir le fichier *backend.min.js* qui sera enregistré dans le dossier asset/js du module **core**.

Cette procédure est similaire pour le *CSS*. GULP vas récupérer tous les \*.backend.jss pour sortir le fichier *backend.min.css qui sera à son tour enregistré dans le dossier "asset/css" du module **core**.

Le fichier "core/action/init.js" permet de déclarer l'objet (qui est une sorte de namespace pour éviter les conflits entre vos différents plugins) qui sera utilisé tout le long de votre dévelopement JS. Nous y reviendrons.

En conclusion: Le module **core** permet de gérer les assets, actions, classes, shortcodes, filtres et vues qui selon vous n'on pas leur place dans un module spécifique.

## Le module "hello-world"

Nous sommes presque au bout; Ouvrons le fichier "hello_world.config.json", si vous avez suivi jusque là vous pouvez imaginer ce qu'il contient:
```json
{
	"name": "Hello World",
	"slug": "hello_world",
	"version": "0.1.0",
	"path": "module/hello-world",
	"dependencies": {
		"action": {}
	}
}
```

Rien de bien compliqué, il faut juste comprendre que ce fichier est appelé grâce à "starter.config.json" grâce à l'entré "module/hello-world/hello_world.config.json" dans le tableau "modules".

Dans ce fichier, nous retrouvons l'entrée "action" dans le tableau "dependencies" ce qui signifie pour EO-Framework qu'il doit inclure tous les fichiers se trouvant dans le dossier "action" du module "hello-world".

### Le fichier "action"

Nous plaçons les actions "add_action( '*', '*' );" de WordPress dans les fichiers au format \*.action.php.

Le fichier hello-world.action.php 

```php
<?php
/**
 * Les actions principales du module "Hello World".
 *
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @since 0.1.0
 * @version 0.1.0
 * @copyright 2015-2017 Eoxia
 * @package EO_Framework_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Les actions principales du module "Hello World".
 */
class Hello_World_Action {

	/**
	 * Le constructeur
	 *
	 * @since 0.1.0
	 * @version 0.1.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ) );
	}


	/**
	 * Ajout du sous menu 'Hello World' dans le menu de WordPress.
	 *
	 * @since 0.1.0
	 * @version 0.1.0
	 */
	public function callback_admin_menu() {
		add_menu_page( 'Hello World', 'Hello World', 'manage_options', 'hello-world', array( $this, 'callback_add_menu_page' ) );
	}

	/**
	 * Le callback pour afficher la vue.
	 *
	 * @since 0.1.0
	 * @version 0.1.0
	 */
	public function callback_add_menu_page() {
		\eoxia\View_Util::exec( 'starter', 'hello_world', 'main' );
	}
}

new Hello_World_Action();
```

Ce fichier est très simple et nécessite aucune explication détailles, il utilise l'action "admin_menu" de WordPress pour ensuite ajouter une page dans le menu de WordPress.

La méthode callback_add_menu_page utilise la méthode static exec de l'objet View_Util pour afficher la vue (template) du module. (Encore une fois, ce README.md n'est pas un tutoriel PHP ou WordPress; Voir EO-Framework pour plus de détails sur cette méthode).

## Liens externes 

* La documentation complète de EO-Framework
* Utiliser le CSS et JS avec GULP grâce à EO-Framework
* La documentation complète du CSS de EO-Framework

* Des plugins en production utilisant EO-Framework
	* Task Manager
	* DigiRisk
	
## TODO

* Relecture/Correction
* Passer en 1.0.0
* Communication
