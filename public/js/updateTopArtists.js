$(document).ready( function(){
    
    $("#timeRangeArtist").on('change', function (){
        var time_range = $(this).val();
        var userID = $('.now-playing').attr('id').match(/\d+/)[0];
        
        $.ajax({
            type: 'GET',
            url: '/ajaxGetTopArtists',
            data: {
                userID: userID,
                time_range: time_range
            },
            
            success: function(response) {
                updateTopArtists(response.topArtists, response.listeningTime);
            },
            error: function(error) {
                $('#card-top-artists').html(`
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Errore nel caricamento dei dati. Riprova più tardi.
                    </div>
                `);
                }
            });
        });
        
    });
    
function updateTopArtists(topArtists, listeningTime) {
    var cardBody = $('#card-top-artists');
    var html = '';
    
    for (var i = 0; i < topArtists.length; i++) {
        var artist = topArtists[i];
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
        
        var artistListeningTime = listeningTime[artist.name] || '0';
        var artistImage = artist.images[0].url;
        
        html += `
            <div class="track-item p-3 mb-3">
                <div class="d-flex align-items-center">
                    <span class="badge ${badgeClass} me-3">${badgeText}</span>
                    <img src="${artistImage}" 
                        alt="Artista" class="rounded-circle me-3" width="50" height="50">
                    <div class="flex-grow-1">
                        <h6 class="mb-0">${artist.name}</h6>
                        <small class="text-secondary">${artistListeningTime}</small>
                    </div>
                    <div class="text-end">
                        <div class="text-spotify">${artist.popularity}</div>
                        <small class="text-secondary">popolarità</small>
                    </div>
                </div>
            </div>
        `;
    }
    
    cardBody.html(html);
}