<?php

/**
 * Class Mentoring_Errors
 *
 * 
 */
class Mentoring_Errors
{

    private $errors;

    /**
     * Register a submission error
     *
     * @since 1.0
     */
    public function add_errors($errors=[])
    {
        $this->errors = $errors;
    }

    /**
     * Get errors
     *
     * @since 1.1
     * @return array
     */
    public function get_errors()
    {
        if (empty($this->errors)) {
            return array();
        }

        return $this->errors;
    }

    /**
     * Print errors
     *
     * @since 1.0
     */
    public function print_errors()
    {

        if (empty($this->errors)) {
            return;
        }

        echo '<div class="alert alert-danger mentoring-errors">';

        foreach ($this->errors as $error_id => $error) {
            if(is_array($error) || is_object($error)){
                foreach ($error as $index => $errorMessage) {
                    echo '<p class="mentoring-error text-center">' . esc_html($errorMessage) . '</p>';
                }
            }else{
                echo '<p class="mentoring-error text-center">' . esc_html($error) . '</p>';
            }
        }

        echo '</div>';
    }
}
