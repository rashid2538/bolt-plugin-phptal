<?php

	namespace BoltPlugin\PHPTAL;

	use Bolt\IPlugin;
	use Bolt\Component;

	class Renderer extends Component implements IPLugin {

		function activate() {
			$this->on( 'getRenderer', [ $this, 'getRenderer' ] );
		}

		function getRenderer() {
			return function() {
				if( $this->getLayout() ) {
					if( file_exists( $this->getConfig( 'defaults/viewPath', 'application/view/' ) . $this->getLayout() . '.' . $this->getConfig( 'view/extension', 'html' ) ) && file_exists( $this->template ) ) {
						$phptal = new \PHPTAL( $this->getConfig( 'defaults/viewPath', 'application/view/' ) . $this->getLayout() . '.' . $this->getConfig( 'view/extension', 'html' ) );
						$phptal->viewTemplate = $this->template;
					}
				} else if( file_exists( $this->template ) ) {
					$phptal = new \PHPTAL( $this->template );
				}
				if( $phptal ) {
					$phptal->viewBag = $this->getViewBag();
					$phptal->model = $this->model;
					$phptal->view = $this;
				}
				return $phptal ? $phptal->execute() : 'PHPTAL could not find the template to parse!';
			};
		}
	}