function textAfterHyphen(string) {
    var parts = string.split('-');
    return parts.length > 1 ? parts[1] : '';
}