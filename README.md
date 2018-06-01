# Call Manager ![Eoxia Logo](https://avatars0.githubusercontent.com/u/3227847?s=200&amp;v=4)
### version 2.0.0

###### Call Manager a été construit avec [eo-framework](https://github.com/Eoxia/eo-framework) il nécessite donc NodeJs ainsi que Gulp (pour les développeurs).
###### Call Manager est un plugin WordPress qui nécessite les plugins suivant pour fonctionner correctement :

* [WPshop](https://github.com/Eoxia/wpshop).
* [task-manager](https://github.com/Eoxia/task-manager).
* [task-manager-wpshop](https://github.com/Eoxia/task-manager-wpshop).

## Fonctionnalités

* Gérer les appels entrants des clients WPshop

## Documentation d'utilisation

* Le plugin ajoute un bouton supplémentaire dans la barre d'outils de WordPress.

* Lors du clique sur ce bouton, une fenêtre s'ouvre.

* Dans cette fenêtre, il vous sera demandé de sélectionner : l'administrateur concerné, le status de l'appel, le client WPshop (ou création du client) et le temps de la tâche (pour Task Manager) .

* Si le client WPshop est introuvable, il vous sera demandé de cliquer sur un bouton "ajouter nouveau client". Un formulaire supplémentaire va ensuite apparaître pour vous permettre de créer un nouveau client WPshop.

* Finalement, entrez un commentaire concernant l'appel reçu et cliquez sur "valider".
Le commentaire sera lié au client de WPshop et à l'administrateur concerné. Il sera également associé à une nouvelle tâche avec la catégorie "appel téléphonique".


## Table

###### Après son activation le plugin ne rajoute pas de table supplémentaire. Les seules tables utilisées sont celles de WordPress 'comments','commentmeta','postmeta','posts','users','usermeta'.
