$(document).ready( function(){
    
    $("#timeRangeTrack").on('change', function (){
        var time_range = $(this).val();
        var userID = $('.now-playing').attr('id').match(/\d+/)[0];
        
        $.ajax({
            type: 'GET',
            url: '/ajaxGetTopTracks',
            data: {
                userID: userID,
                time_range: time_range
            },
            
            success: function(response) {
                updateTopTracks(response.topTracks);
            },
            error: function(error) {
                $('#card-top-tracks').html(`
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Errore nel caricamento dei dati. Riprova più tardi.
                    </div>
                `);
                }
            });
        });
        
    });
    
function updateTopTracks(topTracks) {
        var cardBody = $('#card-top-tracks');
        var html = '';
        
        for (var i = 0; i < topTracks.length; i++) {
            var track = topTracks[i];
            var badgeClass = '';
            var badgeText = '#' + (i + 1);
            
            switch(i) {
                case 0:
                    badgeClass = 'badge-spotify';
                    break;
                case 1:
                    badgeClass = 'bg-secondary';
                    break;
                case 2:
                    badgeClass = 'bg-warning text-dark';
                    break;
                default:
                    badgeClass = 'bg-body-secondary';
            }
            
            var trackImage = track.album.images[0].url;
            
            var artistsNames = '';
            if (track.artists && track.artists.length > 0) {
                artistsNames = track.artists.map(function(artist) {
                    return artist.name;
                }).join(', ');
            }
            
            html += `
                <div class="track-item p-3 mb-3">
                    <div class="d-flex align-items-center">
                        <span class="badge ${badgeClass} me-3">${badgeText}</span>
                        <img src="${trackImage}" 
                            alt="Album" class="album-cover me-3" width="50" height="50">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">${track.name}</h6>
                            <small class="text-secondary">${artistsNames}</small>
                        </div>
                    </div>
                </div>
            `;
        }
        
        cardBody.html(html);
}