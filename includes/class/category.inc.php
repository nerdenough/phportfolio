<?php

    /**
     * "Portfolio Project" Category Class
     * @author Brendan Goodenough
     * @version 1.0
     */

    class Category
    {
        // Variables
        private $_title;
        private $_description;
        private $_projects;

        /**
         * Constructs a new Category object
         * @param string $title Category title
         * @param string $description Category description
         */
        public function __construct($title, $description)
        {
            // Initialize variables
            $this->_title = $title;
            $this->_description = $description;
            $this->_projects = array();
        }

        /**
         * Returns the category title.
         * @return string
         */
        public function getTitle()
        {
            return $this->_title;
        }

        /**
         * Returns the category description.
         * @return sting
         */
        public function getDescription()
        {
            return $this->_description;
        }

        public function addProject($project)
        {
            // Check whether the project already exists
            if (($key = array_search($project, $this->_projects)) === false)
            {
                // Add the project to the array
                array_push($this->_projects, $project);

                // Tell the project it is in this category
                if ($project->getCategory() !== $this)
                {
                    $project->setCategory($this);
                }
            }
        }

        public function removeProject($project)
        {
            // Check whether the project exists
            if (($key = array_search($project, $this->_projects)) !== false)
            {
                // Remove the project from the array
                unset($this->_projects, $project);
            }
        }

        public function getProjects()
        {
            return $this->_projects;
        }
    }

?>
