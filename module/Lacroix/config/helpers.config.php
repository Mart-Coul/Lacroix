<?php

return 

array(
  'factories' => array(
    'navbar_mobile' => function($sm) { 
      return new Lacroix\View\Helper\NavbarMobile($sm); 
    },
  )
);