# Colis Package

Le but est de gérer le stock d'un entrepôt de colis standardisés.
Les colis sont envoyés par différents fournisseurs (commandes d'achat) et contiennent un seul code article.
La création des colis se fait après contrôle de la réception d'une commande.
Chaque type de colis contient une quantité maximale propre à chaque produit.
Un produit peut être conditionné dans un ou plusieurs types de colis.
Un colis ne contient pas obligatoirement la quantité maximale de produits.

le stockage se fait à "hauteur d'homme", de 0 à 180cm.

The aim is to manage the stock of a warehouse for standardized parcels.
The parcels are sent by different suppliers (purchase orders) and contain only one item code.
Parcel creation takes place after checking the receipt of an order.
Each type of parcel contains a maximum quantity specific to each product.
A product can be packaged in one or several types of parcels.
A parcel does not necessarily contain the maximum quantity of products.

Storage is done at "man height", from 0 to 180cm. |



Les colis existent en 4 tailles :
The packages come in 4 sizes:

| Référence colis | longueur en cm | largeur en cm | hauteur en cm | palettisable | Occupation | Stockage |
|-----------------|----------------|---------------|---------------|--------------|------------|----------|
| Package Reference | Length (cm) | Width (cm) | Height (cm) | Palletizable | Occupancy | Storage |
|-----------------|----------------|---------------|---------------|--------------|------------|----------|
| D               | 40             | 30            | 20            | oui          | 1          | court    |
| B               | 40             | 30            | 40            | oui          | 2          | court    |
| C               | 60             | 30            | 20            | non          | 1          | long     |
| A               | 60             | 30            | 40            | non          | 2          | long     |


palettisable : tailles et dispostions optimisées pour couvrir la surface d'une palette de type Europ (80cm x 120cm).

Palletizable: Optimized sizes and arrangements to cover the surface of a Europ pallet (80cm x 120cm).

occupation : chaque élément de stockage est composé de 4 cellules l'une au dessus de l'autre, de taille 2 en hauteur. La largeur et la profondeurs sont celles du colis.

Occupation: Each storage unit consists of 4 cells stacked on top of each other, each 2 units in height. The width and depth are those of the package.

Stockage :  Défini la profondeur du rayonnage.

Storage: Defines the depth of the shelving.

![Paletisation](./asset/36118.webp)


