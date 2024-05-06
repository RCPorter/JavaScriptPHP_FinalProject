window.onload = function (){

    try{
        util.retDocByID('hint_1').value = Folder.openFile('hint1');
        util.retDocByID('hint_2').value = Folder.openFile('hint2');
        util.retDocByID('hint_3').value = Folder.openFile('hint3');
    } catch(error){
        /**There is nothing to do for this, it happens when I load the page
         * for the first time without hints. Just catching it to stop the error
         * from going to console.
         */
    }

}