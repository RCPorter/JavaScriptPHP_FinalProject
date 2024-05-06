const digit = /^(?=.*\d).{1,}$/gm;
const capital = /^(?=.*[A-Z]).{1,}$/gm;
const lower = /^(?=.*[a-z]).{1,}$/gm;
const special = /[@!#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/gm;

window.onload = function() {

    util.retDocByID('pass').addEventListener('input', () => {

        let digitCheck = util.retDocByID('digitCheck');
        let digitX = util.retDocByID('digitX');
        let upperCheck = util.retDocByID('upperCheck');
        let upperX = util.retDocByID('upperX');
        let lowerCheck = util.retDocByID('lowerCheck');
        let lowerX = util.retDocByID('lowerX');
        let specialCheck = util.retDocByID('specialCheck');
        let specialX = util.retDocByID('specialX');
        //Resetting the lastIndex to 0 each time assures that the full string is tested each time
        //Without doing this, the result of the test switches between accurate and inaccurate with every iteration
        digit.lastIndex = 0;
        capital.lastIndex = 0;
        lower.lastIndex = 0;
        special.lastIndex = 0;

        let test = util.retDocByID('pass').value;

        if (digit.test(test)){
            digitCheck.removeAttribute('hidden');
            digitX.hidden = true;
        }
        else {
            digitCheck.hidden = true;
            digitX.removeAttribute('hidden');
        }

        if (capital.test(test)){
            upperCheck.removeAttribute('hidden');
            upperX.hidden = true;
        }
        else {
            upperCheck.hidden = true;
            upperX.removeAttribute('hidden');
        }

        if (lower.test(test)){
            lowerCheck.removeAttribute('hidden');
            lowerX.hidden = true;
        }
        else {
            lowerCheck.hidden = true;
            lowerX.removeAttribute('hidden');
        }

        if (special.test(test)){
            specialCheck.removeAttribute('hidden');
            specialX.hidden = true;
        }
        else {
            specialCheck.hidden = true;
            specialX.removeAttribute('hidden');
        }
    })
};