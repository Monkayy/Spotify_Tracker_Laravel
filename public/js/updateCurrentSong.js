    
function formatTime(time_ms) {
    var minutes = Math.floor(time_ms / 60000);
    var seconds = Math.floor((time_ms / 1000) - minutes * 60);
    var formattedSeconds = seconds < 10 ? "0" + seconds : seconds;
    return `${minutes}:${formattedSeconds}`;
}
    
$("document").ready(function(){
    var $duration = $("#songDurations small[data-duration='currPlaying-duration']");
    var duration_ms = parseInt($duration.attr("id"));
    var duration_formatted = formatTime(duration_ms);
    
    var $elapsed = $("#songDurations small[data-progress='currPlaying-progress']");
    var elapsed_ms = parseInt($elapsed.attr("id"));
    
    var $uid = $('.now-playing').attr('id').match(/\d+/)[0];
    var is_playing = $("#state-button").attr('data-playing') === 'true';
    
    if(is_playing){
        $("#icon-state-button").html('<i class="bi bi-play"></i>');
    } else {
        $("#icon-state-button").html('<i class="bi bi-pause"></i>');
    }
    
    const interval = 100;
    
    // Ogni 'interval' ms aggiorno la barra di avanzamento della canzone
    const timer = setInterval(function () {
        if(is_playing) {
            elapsed_ms += interval;
            
            if (elapsed_ms >= duration_ms) {
                elapsed_ms = duration_ms;
            }
            
            var formattedCurrent = formatTime(elapsed_ms);
            $("#songDurations small[data-progress='currPlaying-progress").text(formattedCurrent);
            
            const progressPercent = (elapsed_ms / duration_ms) * 100;
            $("#progressBar").css("width", `${progressPercent}%`);
        }
        
    }, interval);
    
    // Aggiornamento in tempo reale della canzone corrente ogni 10 secondi
    
    var ajaxTimer = setInterval(function(){
        $.ajax({
            type: 'GET',
            url: '/ajaxUpdateCurrentSong',
            
            data: {
                userID: $uid,
            },
            
            success: function(response) {
                $('#currPlaying-albumCover').attr('src',response.currentlyPlaying['item']['album']['images'][0]['url']);
                $('#currPlaying-songName').text(response.currentlyPlaying['item']['name']);
                $('#currPlaying-artistName').text(response.currentlyPlaying['item']['artists'][0]['name']);
                $('#currPlaying-albumName').text(response.currentlyPlaying['item']['album']['name']);
                
                duration_ms = response.currentlyPlaying['item']['duration_ms'];
                $("#songDurations small[data-duration='currPlaying-duration']").attr('id', duration_ms);
                
                elapsed_ms = response.currentlyPlaying['progress_ms'];
                var was_playing = is_playing;
                is_playing = response.currentlyPlaying['is_playing'];
                $("#state-button").attr('data-isPlaying', is_playing);
                
                if (!was_playing && is_playing) {
                    elapsed_ms = response.currentlyPlaying['progress_ms'];
                }
                
                if(is_playing){
                    $("#icon-state-button").html('<i class="bi bi-pause"></i>');
                } else {
                    $("#icon-state-button").html('<i class="bi bi-play"></i>');
                }
                
                var formattedCurrent = formatTime(elapsed_ms);
                $("#songDurations small[data-progress='currPlaying-progress']").attr('id', elapsed_ms).text(formattedCurrent);
                
                var formattedDuration = formatTime(duration_ms);
                $("#songDurations small[data-duration='currPlaying-duration']").text(formattedDuration);
                
                const progressPercent = (elapsed_ms / duration_ms) * 100;
                $("#progressBar").css("width", `${progressPercent}%`);
            },
        });
    },10*1000)
    
});