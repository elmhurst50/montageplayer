<?php
/*
 * Class to scroll through a montage of images, requires montageInterface
 * View will requie javascript dependancies.
 * @ by Sam Joyce
 * @ February 2014
 */

namespace samjoyce\montageplayer;

class montagePlayer {

    function __construct(montageInterface $montage) {
        $this->montage = $montage;
        $this->settings = array('transition' => 'none', 
            'music' => '0.2', 
            'captions' => 'true',
            'animation' => 'true');
    }

    /**
     * returns the transition setting based on user or default
     * @return int
     */
    public function getTransition() {
        $result = $this->settings["transition"] == 'none' ? 50 : 2000;
        return $result;
    }

    /**
     * returns the manual transition setting based on user or default
     * @return int
     */
    function getManualTransition() {
        $result = $this->settings["transition"] == 'none' ? 50 : 1000;
        return $result;
    }

    //load inital slide
    function loadInitialSlide() {
        echo $this->createSlide(0);
    }

    /*
     * get total number of slides from montage;
     */

    public function numberOfSlides() {
        return $this->montage->numberOfSlides();
    }

    /**
     * Creates the visual html for a slide
     * the --- at the end of the html is a javascript cycle2 requirement
     * @param int $slideNumber slide nummber in slideshow
     * @return string html
     */
    function createSlide($slideNumber) {
        $data = $this->montage->getslide($slideNumber);
        $container = ' <div class="slideshow ' . $data["animation"] . '" id="slideNumber_' . $slideNumber . '"  data-animation="' . $data["animation"] . '">';
        $image = '<img class="slide" src="' . $data["imageURL"] . '" />';

        if ($data["title"] != "" || $data["text"] != "") {
            $textPanel = ' <div class="slide-panel panel">'
                    . '<strong>' . $data["title"] . '</strong>'
                    . '<p>' . $data["text"] . '</p>'
                    . '</div>';
        }

        $close = '</div>---';

        return $container . $image . $textPanel . $close;
    }

    /**
     * Generates all the slides required for the slidehsow
     * @param int $qty amount of slides
     * @param int $start optional starting point
     */
    function createMultipleSlides($qty, $start = 1) {
        for ($x = $start; $x < $qty; $x++) {
            echo $this->createSlide($x);
        }
    }

    /**
     * Loads the music if required
     */
    function loadMusic() {
        if ($this->settings["music"] != 0 && $this->montage->getMusic() !== false && $this->showMusicOnOff == 'on') {
            echo <<<EOD
            <audio id="background-music" autoplay loop>
                <source src="uploads/$this->id/music/$this->id.mp3" type="audio/mpeg">
                Your computer does not support sound
            </audio>
EOD;
            echo '<script>'
            . 'music = document.getElementById("background-music");'
            . 'music.volume = ' . $this->settings["music"]
            . '</script>';
        }
    }

}
