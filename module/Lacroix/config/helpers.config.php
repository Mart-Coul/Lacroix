<?php

return 

array(
  'factories' => array(
    'navbar' => function($sm) { 
      return new Lacroix\View\Helper\NavbarMobile($sm); 
    },
  )
);