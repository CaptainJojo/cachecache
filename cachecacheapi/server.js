'use strict';

const express = require('express');

// Constants
const PORT = 3000;

// App
const app = express();
app.get('/article', function (req, res) {
  res.json(
    {
      id: 3,
      title: 'Un article',
      content: 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un peintre anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n\'a pas fait que survivre cinq siècles, mais s\'est aussi adapté à la bureautique informatique, sans que son contenu n\'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.'
    })
});

app.get('/comment/3', function (req, res) {
  res.json(
    [{
      id: 1,
      author: 'Person1',
      content: 'On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions'
    },{
      id: 2,
      author: 'Person2',
      content: 'De nombreuses suites logicielles de mise en page ou éditeurs de sites Web ont fait du Lorem Ipsum'
    },{
      id: 3,
      author: 'Person3',
      content: 'Plusieurs versions sont apparues avec le temps, parfois par accident'
    },{
      id: 4,
      author: 'Person4',
      content: 'Plusieurs variations de Lorem Ipsum peuvent être trouvées ici ou là'
    },{
      id: 5,
      author: 'Person5',
      content: 'Lorem Ipsum, vous devez être sûr qu\'il n\'y a rien d\'embarrassant caché dans le texte'
    },{
      id: 6,
      author: 'Person6',
      content: 'Tous les générateurs de Lorem Ipsum sur Internet tendent à reproduire le même extrait sans fin'
    }])
});

app.listen(PORT);
console.log('Running on http://localhost:' + PORT);
