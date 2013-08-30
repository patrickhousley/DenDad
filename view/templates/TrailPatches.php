<style>
    #dd_denLevel img {
        position: relative;
    }
    #dd_denLevel_bobcat {
        <?php
            if (isset($this->_data['denRank']) && $this->_data['denRank']
                    >= \DenDad\config\Config::DEN_WEBELOS_FIRST) {
                echo('display: none;');
            }
        ?>
        top: 0px;
    }
    #dd_denLevel_tiger {
        <?php
            if (isset($this->_data['denRank']) && $this->_data['denRank']
                    >= \DenDad\config\Config::DEN_WEBELOS_FIRST) {
                echo('display: none;');
            }
        ?>
        top: 75px;
        left: -79px;
    }
    #dd_denLevel_wolf {
        <?php
            if (isset($this->_data['denRank']) && ($this->_data['denRank']
                    < \DenDad\config\Config::DEN_WOLF || $this->_data['denRank']
                    >= \DenDad\config\Config::DEN_WEBELOS_FIRST)) {
                echo('display: none;');
            }
        ?>
        top: 37px;
        left: -195px;
    }
    #dd_denLevel_bear {
        <?php
            if (isset($this->_data['denRank']) && ($this->_data['denRank']
                    < \DenDad\config\Config::DEN_BEAR || $this->_data['denRank']
                    >= \DenDad\config\Config::DEN_WEBELOS_FIRST)) {
                echo('display: none;');
            }
        ?>
        top: 37px;
        left: -200px;
    }
    #dd_denLevel_webelos {
        <?php
            if (isset($this->_data['denRank']) && $this->_data['denRank']
                    < \DenDad\config\Config::DEN_WEBELOS_FIRST) {
                echo('display: none;');
            } else {
                echo('display: block;');
            }
        ?>
        top: 0px;
        left: 25px;
    }
    #dd_denLevel_aol {
        <?php
            if (isset($this->_data['denRank']) && $this->_data['denRank']
                    < \DenDad\config\Config::DEN_WEBELOS_SECOND) {
                echo('display: none;');
            } else {
                echo('display: block;');
            }
        ?>
        top: 0px;
        left: 22px;
    }
    #dd_cubscout_emblem {
        height: 107px;
    }
</style>
<div id='dd_denLevel'>
<?php if (isset($this->_data['denRank'])): ?>
        <img class='cubscouttrail_bobcat' id='dd_denLevel_bobcat' src='/images/transparent.png' />
        <img class='cubscouttrail_tiger' id='dd_denLevel_tiger' src='/images/transparent.png' />
        <img class='cubscouttrail_wolf' id='dd_denLevel_wolf' src='/images/transparent.png' />
        <img class='cubscouttrail_bear' id='dd_denLevel_bear' src='/images/transparent.png' />
        <img class='cubscouttrail_webelos' id='dd_denLevel_webelos' src='/images/transparent.png' />
        <img class='cubscouttrail_aol' id='dd_denLevel_aol' src='/images/transparent.png' />
<?php else: ?>
        <img id='dd_cubscout_emblem' src='/images/triangle_scout_emblem.png' />
<?php endif; ?>
</div>