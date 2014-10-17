<?php

    /**
     * "Portfolio Project" Portfolio Class
     * @author Brendan Goodenough
     * @version 1.0
     */

    class Portfolio
    {
        // Variables;
        private $_categories;
        private $_projects;

        /**
         * Constructs a new Portfolio object.
         */
        public function __construct()
        {
            // Initialize variables
            $this->_categories = array();
            $this->_projects = array();
        }

        /**
         * Adds a new Category to the portfolio.
         * @param Category $category Category to add
         */
        public function addCategory($category)
        {
            // Check whether the array already exists
            if (($key = array_search($category, $this->_categories)) === false)
            {
                // Add the category to the portfolio
                array_push($this->_categories, $category);
            }
        }

        /**
         * Removes a Category from the portfolio.
         * @param Category $category Category to remove
         */
        public function removeCategory($category)
        {
            // Check whether the category exists
            if (($key = array_search($category, $this->_categories)) !== false)
            {
                // Remove the category from the portfolio
                unset($this->_categories[$key]);
            }
        }

        public function getCategories()
        {
            return $this->_categories;
        }

        public function getCategoryByTitle($title)
        {
            foreach ($this->_categories as $category)
            {
                if ($category->getTitle() === $title)
                {
                    return $category;
                }
            }
        }

        public function addProject($project)
        {
            // Check whether the project already exists
            if (($key = array_search($project, $this->_projects)) === false)
            {
                // Add the project to the array
                array_push($this->_projects, $project);
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
            // Return projects by newest
            return array_reverse($this->_projects);
        }

        public function getProjectByTitle($title)
        {
            foreach ($this->_projects as $project)
            {
                if ($project->getTitle() === $title)
                {
                    return $project;
                }
            }
        }
    }

?>
