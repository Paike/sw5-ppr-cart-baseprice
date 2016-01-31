<?php
/**
 * @category   Shopware
 * @package    Shopware_Plugins_Frontend_PprBasePrice
 * @version    $Id$
 * @author     Patrick Prädikow
 */
class Shopware_Plugins_Frontend_PprBasePrice_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{
	protected function createForm()
    {
        $form = $this->Form();
 
        $form->setElement('boolean', 'pprShowAjaxCart', array(
			'value' => 1,
            'label' => 'Grundpreis im Ajax-Warenkorb anzeigen',
            'required' => false
        ));
        $form->setElement('boolean', 'pprShowCart', array(
			'value' => 1,
            'label' => 'Grundpreis im Warenkorb anzeigen',
            'required' => false
        ));
        $form->setElement('textarea', 'pprBasePriceStyle', array(
			'value' => 
'.cart--base-price {
	font-size:0.7em;
}
.ajaxcart--base-price {
	font-size:0.7em;
	display:block;
}
.is--ctl-checkout .product--table .row--product .column--unit-price, .is--ctl-checkout .product--table .row--product .column--total-price {
	line-height:1.3em
}
@media screen and (min-width: 48em) {

	.cart--base-price {
		display:block;
	}
}',
            'label' => 'CSS Stilanpassung',
            'required' => false
        ));
		/*
		$form->setElement('boolean', 'pprShowConfirm', array(
			'value' => 1,
            'label' => 'Grundpreis auf der Kauf-Abschlussseite anzeigen',
            'required' => false
        ));
		*/
    }
 

 
    public function getCapabilities()
    {
        return array(
            'install' => true,
            'enable' => true,
            'update' => true
        );
    }
 
    /**
     * Gibt den Marketing-Namen des Plugins zurück.
     */
    public function getLabel()
    {
        return 'Grundpreise im Warenkorb und Ajax-Warenkorb';
    }
 
    /**
     * Gibt die Version des Plugins als String zurück
     */
    public function getVersion()
    {
        return "1.0.0";
    }
 
    /**
    * Gibt die gesammelten Plugin-Informationen zurück
    *
    */
    public function getInfo() {
        return array(
			'author' => 'Patrick Prädikow',
            // Die Plugin-Version.
            'version' => $this->getVersion(),
            // Copyright-Hinweis
            'copyright' => 'Copyright (c) 2015, Patrick Prädikow',
            // Lesbarer Name des Plugins
            'label' => $this->getLabel(),
            // Info-Text, der in den Plugin-Details angezeigt wird
            'description' => file_get_contents($this->Path() . 'info.txt'),
            // Anlaufstelle für den Support
            'support' => 'http://forum.shopware.de',
            // Hersteller-Seite
            'link' => 'http://shopware.pradikow.de',
			'source' => 'Community',
            // Änderungen
            'changes' => array(
                '1.0.0'=>array('releasedate'=>'2015-10-27', 'lines' => array(
                    'Erstes Release'
                ))
            ),
            // Aktuelle Revision des Plugins
            //'revision' => '2'
        );
    }

    public function update($version)
    {
        return true;
    }
 
    public function install()
    {
        $this->subscribeEvents();
		$this->createForm();
 
        return true;
    }
 
    public function uninstall()
    {
        return true;
    }

    public function subscribeEvents()
    {
		$this->subscribeEvent(
            'Enlight_Controller_Action_PostDispatch_Frontend',
            'onPostDispatch'
        );
    }
	
    public function onPostDispatch(Enlight_Event_EventArgs $arguments)
    {
        $subject  = $arguments->getSubject();
        $request  = $subject->Request();
        $view     = $subject->View();
		$response = $subject->Response();
		
		if(!$request->isDispatched()
			|| $response->isException() 
			|| $request->getModuleName() != 'frontend' 
			|| $request->getControllerName() != 'checkout'
            || !$view->hasTemplate()
			) {
			return;
		}

		$view->assign('pprShowCart',$this->Config()->pprShowCart);
		$view->assign('pprShowAjaxCart',$this->Config()->pprShowAjaxCart);
		//$view->assign('pprShowConfirm',$this->Config()->pprShowConfirm);
		
		$view->assign('pprBasePriceStyle',$this->Config()->pprBasePriceStyle);
		$view->addTemplateDir($this->Path() . 'Views/');
	}
}