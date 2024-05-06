let lower = util.retDocByID('lower');
let upper = util.retDocByID('upper');

function check(){

    if (lower.checked == false && upper.checked == false){
         lower.checked = true;
    }
}

window.onload = function() {

     Folder.addFile('hint1', hint1);
     Folder.addFile('hint2', hint2);
     Folder.addFile('hint3', hint3);

}