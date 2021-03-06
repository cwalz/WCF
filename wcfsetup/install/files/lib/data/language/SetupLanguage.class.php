<?php
namespace wcf\data\language;
use wcf\system\exception\SystemException;
use wcf\system\io\File;
use wcf\system\language\LanguageFactory;
use wcf\util\XML;

/**
 * SetupLanguage is a modification of Language used during the setup process.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2016 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	WoltLabSuite\Core\Data\Language
 */
class SetupLanguage extends Language {
	/**
	 * @inheritDoc
	 */
	public function __construct($languageID, array $row, Language $language = null) {
		if ($row === null) {
			throw new SystemException('SetupLanguage only accepts an existing dataset.');
		}
		
		parent::__construct(null, $row, null);
	}
	
	/**
	 * @inheritDoc
	 */
	protected function loadCategory($category) {
		return false;
	}
	
	/**
	 * Loads the compiled language file.
	 * Compiles the language file before if necessary.
	 */
	public function loadLanguage() {
		$filename = TMP_DIR.'setup/lang/cache/'.$this->languageCode.'_wcf.setup.php';
		
		if (!file_exists($filename)) {
			$xml = new XML();
			$xml->load(TMP_DIR.'setup/lang/setup_'.$this->languageCode.'.xml');
			
			// get language items
			$categoriesToCache = [];
			$items = $xml->xpath()->query('/ns:language/ns:category/ns:item');
			
			/** @var \DOMElement $item */
			foreach ($items as $item) {
				$categoriesToCache[] = [
					'name' => $item->getAttribute('name'),
					'cdata' => $item->nodeValue
				];
			}
			
			// update language files here
			if (!empty($categoriesToCache)) {
				$file = new File($filename);
				$file->write("<?php\n/**\n* WoltLab Suite\n* language: ".$this->languageCode."\n* encoding: UTF-8\n* category: WCF Setup\n* generated at ".gmdate("r")."\n* \n* DO NOT EDIT THIS FILE\n*/\n");
				foreach ($categoriesToCache as $name) {
					$file->write("\$this->items['".$name['name']."'] = '".str_replace("'", "\'", $name['cdata'])."';\n");
					
					// compile dynamic language variables
					if (strpos($name['cdata'], '{') !== false) {
						$compiledString = LanguageFactory::getInstance()->getScriptingCompiler()->compileString($name['name'], $name['cdata']);
						$file->write("\$this->dynamicItems['".$name['name']."'] = '".str_replace("'", "\'", $compiledString['template'])."';\n");
					}
				}
				
				$file->write("?>");
				$file->close();
			}
		}
		
		include_once($filename);
	}
}
