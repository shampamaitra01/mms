 document.getElementById("btnPrint").onclick = function () {
    printElement(document.getElementById("printThis"));
}

function printElement(elem) {
    var domClone = elem.cloneNode(true);
    
    var $printSection = document.getElementById("printSection");
    
    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }
    
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}

// $(document).on('click', '.btnPrint', function(e) {
//     e.preventDefault();

//     var $this = $(this);
//     var originalContent = $('body').html();
//     var printArea = $this.parents('.printThis').html();

//     $('body').html(printArea);
//     window.print();
//     $('body').html(originalContent);
// });

// $(document).ready(function(){
//     $(document).on('click', '#btnPrint', function (event) {
//         event.preventDefault();
//         var $print = $("#printThis");
//         $(document.body).wrapInner('<div style="display: none"></div>');
//         var $div = $('<div />').append($print.clone().contents()).appendTo(document.body);
//         window.print();
//         $div.remove();
//         $(document.body).children().contents().unwrap();
//     });
// });
function printDiv(div) {    
    // Create and insert new print section
    var elem = document.getElementById(div);
    var domClone = elem.cloneNode(true);
    var $printSection = document.createElement("div");
    $printSection.id = "printSection";
    $printSection.appendChild(domClone);
    document.body.insertBefore($printSection, document.body.firstChild);

    window.print(); 

    // Clean up print section for future use
    var oldElem = document.getElementById("printSection");
    if (oldElem != null) { oldElem.parentNode.removeChild(oldElem); } 
                          //oldElem.remove() not supported by IE

    return true;
}