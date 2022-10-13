removeMask = function(value) {
    console.log(value.replace(/[+-.()\s]/gm, ''));
    return value.replace(/[+-.()\s]/gm, '');
}


