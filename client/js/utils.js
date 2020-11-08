function cloneNodeRecursive(element){
    let ret = element.cloneNode();
    for(let i = 0; i < element.children.length; ++i){
        let child = cloneNodeRecursive(element.children[i]);
        ret.appendChild(child);
    }
    return ret;
}
