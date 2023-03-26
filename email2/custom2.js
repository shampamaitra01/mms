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

