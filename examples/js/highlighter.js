const PHPHighlight = {
    copyClipboard: function (elem) {
        let parent = elem.parentNode.parentNode.parentNode,
            text_to_copy = parent.querySelector('.code-block').textContent;
        console.log(text_to_copy);
        navigator.clipboard.writeText(text_to_copy)
            .then(() => {
                console.log('Text copied to clipboard');
            })
            .catch(err => {
                // This can happen if the user denies clipboard permissions:
                console.error('Could not copy text: ', err);
            });
    }
};