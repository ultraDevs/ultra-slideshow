window.addEventListener('load', function() {

    /** Tabs */
    var usTabs = document.querySelectorAll('ul.mh-nav__tabs > li');

    function usTabsClicks(tabClickEvent) {
        for (var i = 0; i < usTabs.length; i++) {
            usTabs[i].classList.remove('active');
        }

        var clickedTab = tabClickEvent.currentTarget;
        clickedTab.classList.add('active');
        tabClickEvent.preventDefault();


        var tabContent = document.querySelectorAll(".us-tab__pane");

        for (i = 0; i < tabContent.length; i++) {
            tabContent[i].classList.remove('active');
        }

        var anchorRef = tabClickEvent.target;
        var aPanelID = anchorRef.getAttribute("href");

        var activePane = document.querySelector(aPanelID);

        activePane.classList.add('active');
    }

    for (i = 0; i < usTabs.length; i++) {
        usTabs[i].addEventListener('click', usTabsClicks);
    }

    /** Slider Settings */

    var effect = document.querySelector('#g_effect');
    effect.onchange = function(e) {
        var currentEffect = e.target.value;

        if (currentEffect == 'fade' || currentEffect == 'cube' || currentEffect == 'flip') {
            var bp = document.querySelectorAll('#spv');
            for (var i = 0; i < bp.length; i++) {
                bp[i].value = 1;
            }
        } else {
            // Nothing to do :) 
        }
    };
    /** Copy to clipboard */
    var btn = document.querySelector('.copyData');
    btn.onclick = function(e) {
        var text = document.getElementById('uss_shortcode_txt');
        text.select();

        text.setSelectionRange(0, 99999);
        document.execCommand('copy');

        document.querySelector('.copyData').innerHTML = 'Copied to clipboard';
    };
});