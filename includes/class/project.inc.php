<?php

    /**
     * "Portfolio Project" Project Class
     * @author Brendan Goodenough
     * @version 1.0
     */

    class Project
    {
        // Variables
        private $_title;
        private $_description;
        private $_category;
        private $_link;
        private $_thumbnail;

        public function __construct($title, $description)
        {
            $this->_title = $title;
            $this->_description = $description;
        }

        public function getTitle()
        {
            return $this->_title;
        }

        public function getDescription()
        {
            return $this->_description;
        }

        public function getCategory()
        {
            return $this->_category;
        }

        public function setCategory($category)
        {
            $this->_category = $category;

            // Tell the category it holds this project
            if (($key = array_search($this, $category->getProjects())) === false)
            {
                $category->addProject($this);
            }
        }

        public function getLink()
        {
            return $this->_link;
        }

        public function setLink($link)
        {
            $this->_link = $link;
        }

        public function getThumbnail()
        {
            return $this->_thumbnail;
        }

        public function setThumbnail($thumbnail)
        {
            $this->_thumbnail = $thumbnail;
        }
    }

?>
