window.addEventListener('load', function () {

    var updateDBButton = document.getElementById('js-updateDBButton'),
        updateDBCheckbox = document.getElementById('updateDBCheckbox');
    if(updateDBButton !== null) {
        updateDBButton.addEventListener('click', function() {
            updateDBCheckbox.checked = true;
        });
    }

    // $('#js-searchBtn').click(function() {
    //     $('form').hide();
    // });
    // searchBtn.addEventListener('click', function () {
    //     alert("Blah blah...");
    //     console.log('funkcja');
    //     reservationForm.className = reservationForm.className.replace( /(?:^|\s)hidden(?!\S)/g , '');
    //     console.log(reservationForm.className);
    // }, false);

    // var formElement = document.getElementById('js-reservationForm'),
    //     isDoubleRoomReserved = document.forms['reservationForm']['doubleRoom'],
    //     dateFromDoubleRoom = document.forms['reservationForm']['doubleRoomStartDate'],
    //     dateToDoubleRoom = document.forms['reservationForm']['doubleRoomEndsDate'],
    //     extraBedDoubleRoom = document.forms['reservationForm']['extraBedDoubleRoom'],
    //     numberOfBeds = document.forms['reservationForm']['quantityDoubleRoom'],
    //     isTripleRoomReserved = document.forms['reservationForm']['tripleRoom'],
    //     dateFromTripleRoom = document.forms['reservationForm']['tripleRoomStartDate'], 
    //     dateToTripleRoom = document.forms['reservationForm']['tripleRoomEndsDate'],                            
    //     extraBedTripleRoom = document.forms['reservationForm']['tripleRoomExtraBed'],
    //     numberOfTripleBeds = document.forms['reservationForm']['quantityTripleRoom'];                           
                                        

    // isDoubleRoomReserved.addEventListener('change', enableDoubleRoom);
    // isTripleRoomReserved.addEventListener('change', enableTripleRoom);

    // // js-doubleRoom
    // function enableDoubleRoom() {
    //     if(isDoubleRoomReserved.checked === true) {
    //         dateFromDoubleRoom.removeAttribute('disabled');
    //         dateToDoubleRoom.removeAttribute('disabled');
    //         extraBedDoubleRoom.removeAttribute('disabled');
    //         numberOfBeds.removeAttribute('disabled');
    //     }
    //     else{
    //         dateFromDoubleRoom.setAttribute('disabled', true);
    //         dateToDoubleRoom.setAttribute('disabled', true);
    //         extraBedDoubleRoom.setAttribute('disabled', true);
    //         numberOfBeds.setAttribute('disabled', true);
    //     }
    // }
    // // js-tripleRoom
    // function enableTripleRoom() {
    //     if(isTripleRoomReserved.checked === true) {
    //         dateFromTripleRoom.removeAttribute('disabled');
    //         dateToTripleRoom.removeAttribute('disabled');
    //         extraBedTripleRoom.removeAttribute('disabled');
    //         numberOfTripleBeds.removeAttribute('disabled');
    //     }
    //     else{
    //         dateFromTripleRoom.setAttribute('disabled', true);
    //         dateToTripleRoom.setAttribute('disabled', true);
    //         extraBedTripleRoom.setAttribute('disabled', true);
    //         numberOfTripleBeds.setAttribute('disabled', true);
    //     }
    // }
});