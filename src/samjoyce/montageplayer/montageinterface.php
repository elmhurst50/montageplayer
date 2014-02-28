<?php

namespace samjoyce\montageplayer;

interface montageInterface {

//return int number of slides in montage
    public function numberOfSlides();

//return slide data based on the number slide
    public function getSlide($slide);

    //return the music, false if no music
    public function getMusic();
}
