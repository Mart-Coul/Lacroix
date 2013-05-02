<?Php

namespace Main\View\Helper;

use Zend\View\Helper\AbstractHelper;
 
class Bootstrap extends AbstractHelper {
  public function __invoke() {
    return $this;
  }

  public function row($element) {
    $output = '';

    $errors = $this->view->formElementErrors($element);
    if ($errors) {
      $output .= sprintf('<div class="alert alert-error errors"><button type="button" class="close" data-dismiss="alert">&times;</button>%s</div>', $errors);
    };

    $this->addLabelClass($element);

    if (in_array($element->getAttribute('type'), array('submit', 'button', 'reset'))) {
      $element->setAttribute('class', 'btn');
    };

    if ($element->getAttribute('type') == 'hidden') {
      $output .= $this->view->formElement($element);
    } else {
      $row_type = '';
      if ($element instanceof \Zend\Form\Element\Radio) {
        $row_type = 'radio-control-group';
      };

      $output .= sprintf('<div class="control-group %s">',
                         $row_type);
      if ($element->getLabel()) {
        $output .= $this->label($element);
      };

      $output .= sprintf('<div class="controls">%s</div>',
                         $this->element($element));

      $output .= '</div>';
    };

    return $output;
  }
  
public function row2($element) {
    $output = '';

    $errors = $this->view->formElementErrors($element);
    if ($errors) {
      $output .= sprintf('<div class="alert alert-error errors"><button type="button" class="close" data-dismiss="alert">&times;</button>%s</div>', $errors);
    };

    $output .= sprintf('<div class="control-label">%s ', $element->getLabel());
    $output .= '<span class="yesno-options">';
    $output .= sprintf('<label class="radio"><input type="radio" name="%s" %s value="0"/>%s</label>',
                       htmlspecialchars($element->getName()),
                       $element->getValue() === '0' ? 'checked="checked"' : '',
                       $this->view->translate('No'));
    $output .= sprintf('<label class="radio"><input type="radio" name="%s" %s value="1"/>%s</label>',
                       htmlspecialchars($element->getName()),
                       $element->getValue() === '1' ? 'checked="checked"' : '',
                       $this->view->translate('Yes'));
    $output .= '</span></div>';



    return $output;
  }

  public function label($element) {
    return $this->view->formLabel($element);
  }

  public function element($element) {
    if (in_array($element->getAttribute('type'), array('submit', 'button', 'reset'))) {
      $element->setAttribute('class', 'btn');
    };

    return $this->view->formElement($element);
  }

  public function yes_no_row($element) {
    $output = '<div class="control-group row-fluid yesno-group">';

    $errors = $this->view->formElementErrors($element);
    if ($errors) {
      $output .= sprintf('<div class="alert alert-error errors"><button type="button" class="close" data-dismiss="alert">&times;</button>%s</div>', $errors);
    };

    $output .= '<div class="span4">';
    $output .= sprintf('<div class="control-label">%s ', $element->getLabel());
    $output .= '<span class="yesno-options">';
    $output .= sprintf('<label class="radio"><input type="radio" name="%s-yesno" %s value="0"/>%s</label>',
                       htmlspecialchars($element->getName()),
                       !$element->getValue() ? 'checked="checked"' : '',
                       $this->view->translate('No'));
    $output .= sprintf('<label class="radio"><input type="radio" name="%s-yesno" %s value="1"/>%s</label>',
                       htmlspecialchars($element->getName()),
                       $element->getValue() ? 'checked="checked"' : '',
                       $this->view->translate('Yes'));
    $output .= '</span></div>';
    $output .= '</div><div class="span7">';
    $output .= sprintf('<textarea name="%s" placeholder="%s" class="side input-block-level">%s</textarea>',
                       htmlspecialchars($element->getName()),
                       htmlspecialchars($element->getLabel()),
                       htmlspecialchars($element->getValue()));

    $output .= '</div>';

    $output .= '</div>';

    return $output;
  }

  public function block_level($element) {
    $output = '';

    $errors = $this->view->formElementErrors($element);
    if ($errors) {
      $output .= sprintf('<div class="alert alert-error errors"><button type="button" class="close" data-dismiss="alert">&times;</button>%s</div>', $errors);
    };

    $this->addLabelClass($element);

    if (in_array($element->getAttribute('type'), array('submit', 'button', 'reset'))) {
      $element->setAttribute('class', 'btn');
    } else {
      $element->setAttribute('class', $element->getAttribute('class') .' input-block-level');
    }


    if ($element->getAttribute('type') == 'hidden') {
      $output .= $this->view->formElement($element);
    } else {
      if ($element->getLabel()) {
        $output .= $this->label($element);
      };
      $output .= $this->view->formElement($element);
    };

    return $output;
  }

  public function label_wrapped($element) {
    $output = $this->errors($element);

    if (in_array($element->getAttribute('type'), array('checkbox'))) {
      $output .= sprintf('<label class="checkbox">%s %s</label>', 
                         $element->getLabel(),
                         $this->view->formElement($element));
    } else {
      $output .= sprintf('<label>%s %s</label>', 
                         $element->getLabel(),
                         $this->view->formElement($element));
    }

    return $output;
  }

  public function errors($element) {
    $errors = $this->view->formElementErrors($element);
    if (!$errors) {
      return '';
    };
    return sprintf('<div class="alert alert-error errors"><button type="button" class="close" data-dismiss="alert">&times;</button>%s</div>', $errors);
  }

  public function openTag($form) {
    $form->setAttribute('class', 'form-horizontal');
    return $this->view->form()->openTag($form);
  }

  public function openTagPlain($form) {
    $form->prepare();
    return $this->view->form()->openTag($form);
  }

  public function closeTag($form) {
    return $this->view->form()->closeTag();
  }

  public function form($form) {
    $form->prepare();

    $output = $this->openTag($form);

    foreach ($form as $element) {
      $output .= $this->row($element);
    };

    $output .= $this->closeTag($form);
    return $output;
  }

  protected function addLabelClass($element) {
    $attrs = $element->getLabelAttributes();
    if (!$attrs) {
      $attrs = array();
    };

    $class = isset($attrs['class']) ? $attrs['class'] : '';
    $class .= ' control-label';

    if ($element instanceof \Zend\Form\Element\Radio) {
      $class .= ' radio';
    };

    $attrs['class'] = $class;

    $element->setLabelAttributes($attrs); 
  }
  
  protected function addLabelClass2($element) {
    $attrs = $element->getLabelAttributes();
    if (!$attrs) {
      $attrs = array();
    };


    if ($element instanceof \Zend\Form\Element\Radio) {
      $class .= ' radio';
    };

    $attrs['class'] = $class;

    $element->setLabelAttributes($attrs); 
  }
}

?>