# Hackathon_PHP7

If you want to run your Magento 1.x website on PHP7, you need to make some little tweaks in your some Magento 1.x files to make it work without any issues.

Most of Magento code is still valid in PHP 7, there are few incompatibilities listed below:

1. Uniform Variable Syntax issues:

1.1 app/code/core/Mage/Core/Model/Layout.php:555
This file causes and fatal error which crashes Magento. Override the file and replace

$out .= $this->getBlock($callback[0])->$callback[1]();
with

$out .= $this->getBlock($callback[0])->{$callback[1]}();


1.2 app\code\core\Mage\ImportExport\Model\Import\Uploader.php:135
This file effects Magento CSV importer. Override the file, then override _validateFile() function and replace the line 135 with replace

$params['object']->$params['method']($filePath);
with

$params['object']->{$params['method']}($filePath);


1.3 app\code\core\Mage\ImportExport\Model\Export\Entity\Product\Type\Abstract.php:99
This issue effect export functionality of Magento. Magento extends three classes from above abstract class, so root cause of error inside below class is the line#99 in above class.

Mage_ImportExport_Model_Export_Entity_Product_Type_Configurable Mage_ImportExport_Model_Export_Entity_Product_Type_Grouped Mage_ImportExport_Model_Export_Entity_Product_Type_Simple

We need to override above three classes in our local code pool and override overrideAttribute() function, replace line#99

$data['filter_options'] = $this->$data['options_method']();
with

$data['filter_options'] = $this->{$data['options_method']}();


1.4 app\code\core\Mage\ImportExport\Model\Export\Entity\Customer.php:250
This file effects export customers functionality. Override above file and change the line#250 as shown below

$data['filter_options'] = $this->$data['options_method']();
with

$data['filter_options'] = $this->{$data['options_method']}();


1.5 lib\Varien\File\Uploader.php:259
File uploading will not work. Magento extends Mage_Core_Model_File_Uploader from above class, so we need to override this class and rewrite _validateFile() function replace below line

$params['object']->$params['method']($this->_file['tmp_name']);
with

$params['object']->{$params['method']}($this->_file['tmp_name']);


2. Type casting Issue

2.1 app\code\core\Mage\Core\Model\Resource\Session.php:218
Magento Sessions don’t work on PHP 7, so as a result user login doesn’t work. read($sessId) function should return a string so typecast the return variable as given below

return $data;
with

return (string)$data;


3. Incorrect Grand Total

Incorrect totals are due to wrong sort order of subtotal, discount, shipping etc Correct the sort order by creating an extension and put below code in config.xml of the extension

<global>
    <sales>
        <quote>
            <totals>
                <msrp>
                    <before>grand_total</before>
                </msrp>
                <shipping>
                    <after>subtotal,freeshipping,tax_subtotal,msrp</after>
                </shipping>
            </totals>
        </quote>
    </sales>
</global>
