// console.log(Handlebars.helpers);

// Handlebars.registerHelper("solidmath", function(lvalue, operator, rvalue, options) {
//     lvalue = parseFloat(lvalue);
//     rvalue = parseFloat(rvalue);
        
//     return {
//         "+": lvalue + rvalue,
//         "-": lvalue - rvalue,
//         "*": lvalue * rvalue,
//         "/": lvalue / rvalue,
//         "%": lvalue % rvalue
//     }[operator];
// });

// console.log(Handlebars.helpers);

function waitForElement(){
    if(typeof Handlebars !== "undefined"){
        Handlebars.registerHelper("solidmath", function(lvalue, operator, rvalue, options) {
		    lvalue = parseFloat(lvalue);
		    rvalue = parseFloat(rvalue);
		        
		    return {
		        "+": lvalue + rvalue,
		        "-": lvalue - rvalue,
		        "*": lvalue * rvalue,
		        "/": lvalue / rvalue,
		        "%": lvalue % rvalue
		    }[operator];
		});
    }
    else{
        setTimeout(waitForElement, 250);
    }
}

waitForElement();