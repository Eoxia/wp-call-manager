# Call Manager ![Eoxia Logo](https://avatars0.githubusercontent.com/u/3227847?s=200&amp;v=4)
### version 2.0.0

###### Call Manager a etais construit avec [eo-framework](https://github.com/Eoxia/eo-framework) il nécessite donc NodeJs ainsi que Gulp .
###### Call Manager est un plugin WordPress qui nécessite les plugins suivant pour fonctionner correctement :

* [WP_shop](https://github.com/Eoxia/wpshop).
* [task-manager](https://github.com/Eoxia/task-manager).
* [task-manager-wpshop](https://github.com/Eoxia/task-manager-wpshop).

## Fonctionnalitées

* Le plugin ajoute 1 bouton supplémentaire dans l'admin bar de WordPress .

* au clique sur ce bouton une modal s'ouvre.

* dans cette modal il vous sera demander de sélectionner l'administrateur concerner, le status de l'appel, le client Wp_shop (ou creation du client) et le temps de la tache (pour task-manager) .

* si le client Wp_shop est introuvable il vous sera demander de cliquer sur un bouton "ajouter nouveau client", après un formulaire supplémentaire va apparaître pour vous permettre de crée un nouveau clients WP_shop .

* Après il vous reste juste à taper un commentaire concernant l'appel reçu et cliquer sur validé . le commentaire sera liée au clients et à l'administrateur concerné .

* de plus le commentaire correspondra à une une nouvelle tache dans le plugin task-manager avec la category "appel téléphonique".


## Table

###### Après son activation le plugin ne rajoute pas de table supplémentaire les seuls tables utilisées sont celle de WordPress 'comments','commentmeta','postmeta','posts','users','usermeta'.
