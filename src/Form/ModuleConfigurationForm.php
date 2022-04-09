<?php

namespace Drupal\getimages\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class ModuleConfigurationForm extends ConfigFormBase{

    public function getFormId(){
        return 'getimages_admin_settings';
    }

    protected function getEditableConfigNames()
    {
        return[
            'getimages.admin_settings',
        ];
    }

    public function buildForm(array $form, FormStateInterface $form_state){
        $config = $this->config('getimages.admin_settings');
        $form['root_url'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Root URL'),
            '#default_value' => $config->get('getimages_root_url'),
        ];

        $form['api_path'] = [
            '#type' => 'textfield',
            '#title' => $this->t('API Path'),
            '#default_value' => $config->get('getimages_api_path'),
        ];

        $form['content_type'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Content Type'),
            '#default_value' => $config->get('getimages_content_type'),
        ];

        return parent::buildForm($form, $form_state);
    }

    public function submitForm(array &$form, FormStateInterface $form_state){
        $this->config('getimages.admin_settings')
        ->set('getimages_root_url', $form_state->getValue('root_url'))
        ->set('getimages_api_path', $form_state->getValue('api_path'))
        ->set('getimages_content_type', $form_state->getValue('content_type'))
        ->save();
    }

}
