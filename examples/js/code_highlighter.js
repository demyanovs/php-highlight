var codeHighlighter = {
    copyClipboard: function (elem) {
        //var text_to_copy = 'Text to be copied';
        var text_to_copy = document.getElementById('ttt').textContent;
        console.log(text_to_copy);
        navigator.clipboard.writeText(text_to_copy)
            .then(() => {
                console.log('Text copied to clipboard');
            })
            .catch(err => {
                // This can happen if the user denies clipboard permissions:
                console.error('Could not copy text: ', err);
            });

        console.log('copied');

    },
    animateCopiedText: function (clickedElement) {
        var start = null;

        var animationElement = document.createElement('p');
        animationElement.innerHTML = "Copied!";
        animationElement.style.position = "absolute";
        // https://stackoverflow.com/questions/442404/retrieve-the-position-x-y-of-an-html-element
        // https://stackoverflow.com/questions/6802956/how-to-position-a-div-in-a-specific-coordinates

        animationElement.style.left = clickedElement.offsetLeft + 'px';
        animationElement.style.top = clickedElement.offsetTop + 'px';

        clickedElement.appendChild(animationElement);

        var animationDuration = 1000; // milliseconds

        function step(timestamp)
        {
            if (!start)
            {
                start = timestamp;
            }

            var distanceToTravel = 100; // pixels
            var alphaToChange = 1.0;

            var timediffFromStart = timestamp - start;
            var progressPercentage = timediffFromStart / animationDuration;
            var posDiff = 10 + (progressPercentage * distanceToTravel);
            var alphaDiff = progressPercentage * alphaToChange;
            animationElement.style.top = clickedElement.offsetTop + posDiff + 'px';
            var alpha = 1.0 - alphaDiff;
            animationElement.style.color = "rgba(0,0,0," + alpha + ")";

            if (timediffFromStart < animationDuration)
            {
                window.requestAnimationFrame(step);
            }
            else
            {
                animationElement.parentNode.removeChild(animationElement);
            }
        }

        window.requestAnimationFrame(step);
    }
};