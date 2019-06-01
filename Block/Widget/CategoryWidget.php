<?php
namespace Emizentech\CategoryWidget\Block\Widget;

class CategoryWidget extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
     protected $_template = 'widget/categorywidget.phtml';

    /**
     * Default value for products count that will be shown
     */
     const DEFAULT_IMAGE_WIDTH = 250;
     const DEFAULT_IMAGE_HEIGHT = 250;

     protected $_categoryFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Catalog\Helper\Category $categoryHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory
    ) {
        $this->_categoryFactory = $categoryFactory;
        parent::__construct($context);
    }

    /**
     * Retrieve current store categories
     *
     * @param bool|string $sorted
     * @param bool $asCollection
     * @param bool $toLoad
     * @return \Magento\Framework\Data\Tree\Node\Collection|\Magento\Catalog\Model\Resource\Category\Collection|array
     */
    public function getCategoryCollection() {
        $category = $this->_categoryFactory->create();

        if($this->getData('parentcat') > 0){
            $rootCat = $this->getData('parentcat');
                $category->load($rootCat);
        }

        if(!$category->getId()){
            $rootCat = $this->_storeManager->getStore()->getRootCategoryId();
            $category->load($rootCat);
        }

        $storecats = $category->getCategories($rootCat, 1, true, false, true);
        return $storecats;
    }


    /**
     * Get the title
     * @return string
     */
    public function getTitle() {
        // var_dump($this->getData());
        return $this->getData('title');
    }


    /**
     * Get the title
     * @return string
     */
    public function getViewAllURL() {
        // var_dump($this->getData());
        return $this->getData('viewallurl');
    }


    function name2css($string) {
        //Lower case everything
        $string = strtolower($string);
        //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;
    }

    public function canShowImage() {
        if ($this->getData('image') == 'image') {
            return true;
        }
        return false;
    }
}
