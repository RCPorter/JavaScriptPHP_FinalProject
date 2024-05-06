"use strict";
let util = {
    retDocByID: function(id) { return document.getElementById(id); },
    retDocByName: function(name) { return document.getElementsByName(name) }
}

class Folder{
    static addFile(key, value){
        sessionStorage.setItem(key, value);
    }
    static openFile(key){
        return sessionStorage.getItem(key);
    }
}