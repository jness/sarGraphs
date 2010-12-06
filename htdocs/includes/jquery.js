$(document).ready(function(){

        //Hide (Collapse) the toggle containers on load
        $(".toggle_container").hide(); 

        //Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
        $("h2.trigger").click(function(){
                $(this).toggleClass("active").next().slideToggle("slow");
                return false; //Prevent the browser jump to the link anchor
        });

});
