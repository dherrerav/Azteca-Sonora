<?php
// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgButtonVideo extends JPlugin
{
	public $plugin;
	public $params;
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
		$this->plugin = JPluginHelper::getPlugin('editors-xtd', 'video');
		$this->params = new JParameter($this->plugin->params);
	}

	/**
	 * Display the button
	 *
	 * @return array A two element array of (imageName, textToInsert)
	 */
	public function onDisplay($name, $asset, $author) {
		$app = JFactory::getApplication();
		$params = JComponentHelper::getParams('com_media');
 		$user = JFactory::getUser();
		if (	$user->authorise('core.edit', $asset)
			||	$user->authorise('core.create', $asset)
			||  count($user->getAuthorisedCategories($asset, 'core.create')) > 0
			|| ($user->authorise('core.edit.own', $asset) && $author == $user->id)) 
		{
			$link = 'index.php?option=com_media&amp;view=videos&amp;tmpl=component&amp;e_name=' . $name . '&amp;asset=' . $asset . '&amp;author=' . $author . '&amp;folder=' . $this->params->get('folder');
			JHtml::_('behavior.modal');
			$button = new JObject;
			$button->set('modal', true);
			$button->set('link', $link);
			$button->set('text', JText::_('PLG_VIDEO_BUTTON_VIDEO'));
			$button->set('name', 'video');
			$button->set('options', "{handler: 'iframe', size: {x: 800, y: 500}}");
			return $button;
		}
				else
		{
			return false;
		}
	}
}
