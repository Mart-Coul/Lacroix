<?php

namespace Main;

return 

array(
  'factories' => array(
    'navbar' => function($sm) { 
      return new View\Helper\Navbar($sm); 
    },

    'poLink' => function($sm) { 
      return new View\Helper\PoLink(); 
    },

    'bootstrap' => function($sm) { 
      return new View\Helper\Bootstrap(); 
    },

    'currentIdentity' => function($sm) { 
      return new View\Helper\CurrentIdentity($sm); 
    }
  )
);