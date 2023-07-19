$(document).ready(function() {
    $("body").on("keydown", ".no-space-validation", function(t) {
        if (32 === t.which ) return !1
    }),$("body").on("keydown", ".one-space-validation", function(t) {
        if (32 === t.which && 0 === t.target.selectionStart) return !1
    }), $("body").on("keydown", ".two-space-validation", function(t) {
        return (32 !== t.which || 0 !== t.target.selectionStart) && ((32 !== t.which || 1 !== t.target.selectionStart) && void 0)
    }), $("body").on("keydown", ".three-space-validation", function(t) {
        return console.log(t.target.selectionStart), (32 !== t.which || 0 !== t.target.selectionStart) && ((32 !== t.which || 1 !== t.target.selectionStart) && ((32 !== t.which || 2 !== t.target.selectionStart) && void 0))
    }), $("body").on("keypress", ".nicEdit-main", function(t) {
        var h = t.charCode;
        if (!(h >= 48 && h <= 57 || h >= 65 && h <= 88 || h >= 95 && h <= 122 || 0 == h || 13 == h || 32 == h || 34 == h || 39 == h || 40 == h || 41 == h || 44 == h || 46 == h)) return t.preventDefault(), !1
    }), $("body").on("keydown", ".nicEdit-main", function(t) {
        return console.log("which =>", t.which), console.log("selectionStart =>", t.target.selectionStart), (32 !== t.which || 0 !== t.target.selectionStart) && ((32 !== t.which || 1 !== t.target.selectionStart) && ((32 !== t.which || 2 !== t.target.selectionStart) && void 0))
    }),$("body").on("keypress", ".char-validation", function(t) {
        var h = t.charCode;
        console.log(h), h >= 65 && h <= 120 || 0 == h || 121 == h || 122 == h || t.preventDefault()
    }),

    /* Two Decimal points */
    // if (charCode > 31 && (charCode < 48 || charCode > 57) && !(charCode == 46 || charCode == 8))
/*     $("body").on("keypress", ".two-decimal-only-validation", function(t) {
        var h = t.charCode;
        
        // console.log(h), h > 31 && (h < 48 || h > 57) && !(h == 46 || h == 8) || t.preventDefault()
        var len = $(this).val().length;
        var index = $(this).val().indexOf('.');
        if (index > 0 && h == 46) {
          return false;
        }
        if (index > 0) {
          var CharAfterdot = (len + 1) - index;
          if (CharAfterdot > 3) {
            return false;
          }
        }
         
        return true;
    }), */
    $("body").on("keypress", ".two-decimal-only-validation", function(t) {
        var h = t.charCode;
        
        // console.log(h), h > 31 && (h < 48 || h > 57) && !(h == 46 || h == 8) || t.preventDefault()
        // var charCode = (evt.which) ? evt.which : event.keyCode
    if (h > 31 && (h < 48 || h > 57) && !(h == 46 || h == 8))
         return false;
         else {
        var len = $(this).val().length;
        var index = $(this).val().indexOf('.');
        if (index > 0 && h == 46) {
          return false;
        }
        if (index > 0) {
          var CharAfterdot = (len + 1) - index;
          if (CharAfterdot > 3) {
            return false;
          }
        }
    }
        return true;
    }),

    $("body").on("keypress", ".char-and-spcs-validation", function(t) {
       
            var code = t.charCode;
            if (!(code == 32) && // space
              !(code > 64 && code < 91) && // upper alpha (A-Z)
              !(code > 96 && code < 123)) { // lower alpha (a-z)
              t.preventDefault();
            }
        
    }),

    $("body").on("keypress", ".char-spcs-validation", function(t) {
        var h = t.charCode;
        console.log(h),h > 64 && h < 91 || h > 96 && h < 123 || h == 8 || h == 32 || h >= 48 && h <= 57 || t.preventDefault()
    }), 
    $("body").on("keypress", ".only-char-validation", function(t) {
        var h = t.charCode;
        console.log(h), h >= 65 && h <= 120 || 0 == h || 121 == h || 122 == h || t.preventDefault()
    }), $("body").on("keypress", ".src", function(t) {
        if (13 == t.which) return $(".submit-btn").click(), !1
    }), $("body").on("keypress", ".price-validation", function(t) {
        if (console.log(t.which), !(t.which >= 48 && t.which <= 57) && 46 != t.which) return !1
    }), $("body").on("keydown", ".indian-mobile-series", function(t) {
        return console.log(t.which), (t.ctrlKey==true && (t.which == 67 || t.which == 86)) || t.which > 53 && t.which < 58 || 8 == t.which || 0 !== t.target.selectionStart ? (t.which > 47 && t.which < 58 || t.which > 96 && t.which < 108 || 8 == t.which || 1 !== t.target.selectionStart) && ((t.which > 47 && t.which < 58 || 8 == t.which || 2 !== t.target.selectionStart) && ((t.which > 47 && t.which < 58 || 8 == t.which || 3 !== t.target.selectionStart) && ((t.which > 47 && t.which < 58 || 8 == t.which || 4 !== t.target.selectionStart) && ((t.which > 47 && t.which < 58 || 8 == t.which || 5 !== t.target.selectionStart) && ((t.which > 47 && t.which < 58 || 8 == t.which || 6 !== t.target.selectionStart) && ((t.which > 47 && t.which < 58 || 8 == t.which || 7 !== t.target.selectionStart) && ((t.which > 47 && t.which < 58 || 8 == t.which || 8 !== t.target.selectionStart) && ((t.which > 47 && t.which < 58 || 8 == t.which || 9 !== t.target.selectionStart) && void 0)))))))) : ($(".name").css("display", "none"), $("#lengthMob").css("display", "none"), $("#emptyMob").css("display", "none"), $("#login_otp").css("display", "none"), $("#register_otp").css("display", "none"), $("#validNumber").css("display", "block"), !1)
    }), $("body").on("keypress", ".number-validation", function(t) {
        if (8 != t.which && 0 != t.which && (t.which < 48 || t.which > 57)) return !1
    }), 
    // $("body").on("keypress", ".only-num-and-char", function(t) {
    //     var h = t.charCode;
    //     h >= 97 && h <= 122 || h >= 48 && h <= 57 || t.preventDefault()
    // }), 
    $("body").on("keydown", ".pancard-validation", function(t) {
        return console.log("which =>", t.which), console.log("selectionStart =>", t.target.selectionStart), (t.which > 64 && t.which < 91 || 8 == t.which || 0 !== t.target.selectionStart) && ((t.which > 64 && t.which < 91 || 8 == t.which || 1 !== t.target.selectionStart) && ((t.which > 64 && t.which < 91 || 8 == t.which || 2 !== t.target.selectionStart) && ((t.which > 64 && t.which < 91 || 8 == t.which || 3 !== t.target.selectionStart) && ((t.which > 64 && t.which < 91 || 8 == t.which || 4 !== t.target.selectionStart) && ((t.which > 47 && t.which < 59 || 8 == t.which || 5 !== t.target.selectionStart) && ((t.which > 47 && t.which < 59 || 8 == t.which || 6 !== t.target.selectionStart) && ((t.which > 47 && t.which < 59 || 8 == t.which || 7 !== t.target.selectionStart) && ((t.which > 47 && t.which < 59 || 8 == t.which || 8 !== t.target.selectionStart) && ((t.which > 64 && t.which < 91 || 8 == t.which || 9 !== t.target.selectionStart) && void 0)))))))))
    }), $("body").on("keydown", ".time", function(t) {
        return console.log("which =>", t.which), console.log("selectionStart =>", t.target.selectionStart), (t.which > 47 && t.which < 87 || 8 == t.which || 39 == t.which || 37 == t.which || 0 !== t.target.selectionStart) && ((t.which > 47 && t.which < 87 || 8 == t.which || 39 == t.which || 37 == t.which || 1 !== t.target.selectionStart) && ((186 == t.which || 8 == t.which || 39 == t.which || 37 == t.which || 2 !== t.target.selectionStart) && ((51 == t.which || 48 == t.which || 8 == t.which || 39 == t.which || 37 == t.which || 3 !== t.target.selectionStart) && ((48 == t.which || 8 == t.which || 39 == t.which || 37 == t.which || 4 !== t.target.selectionStart) && ((65 == t.which || 80 == t.which || 8 == t.which || 39 == t.which || 37 == t.which || 5 !== t.target.selectionStart) && ((77 == t.which || 8 == t.which || 39 == t.which || 37 == t.which || 6 !== t.target.selectionStart) && void 0))))))
    }), $("#file-upload").each(function() {
        $this = $(this), $this.on("change", function() {
            var t = $this[0].files[0].size,
                h = ($this[0].files[0].type, $this[0].files[0].name),
                i = h.substring(h.lastIndexOf(".") + 1);
            return validExtensions = ["jpg", "jpeg", "png"], -1 == $.inArray(i, validExtensions) ? (alert("This type of files are not allowed!"), this.value = "", !1) : !(t > 3145728) || (alert("File size too large! Please upload less than 3MB"), this.value = "", !1)
        })
    })/*, $("body").on("keydown", ".hour-time-validation", function(t) {
        if(32 !== t.which || 0 !== t.target.selectionStart){
            if ((49 != t.which || 50 != t.which) && 8 != t.which ) {
                    return !1
                
            }
        }
    })*/,

    $("body").on("keypress", ".only-num-and-char", function(t) {
        (t.charCode >= 65 && t.charCode <= 90) || (t.charCode >= 97 && t.charCode <= 122) || (t.charCode >= 48 && t.charCode <= 57) || t.preventDefault()
    })

    $(".check-email-input").blur(function(){
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;  
        var emailaddress = $("check-email-input").val();
        
        // if(!emailReg.test(emailaddress)){
        //     console.log('bad');
        //     $(".email-input-error").html('<font color="#cc0000">Please enter valid Email address</font>');
        //     return !1
        // }else{
        //     console.log('good');
        //     $(".email-input-error").html('<font color="#cc0000"></font>');
        //     return 1
        // }
    }), $("body").on("keypress", ".char-num-and-spcs", function(t) {
        var h = t.charCode;
        h >= 97 && h <= 122 || h >= 48 && h <= 57 || 32 == h || 0 == h || 121 == h || 122 == h || t.preventDefault()
    }),
    $("body").on("input", '.not-allow-spaces', function() {$(this).val($(this).val().replace(/ /g, ""));});



    // Check only two digit after number
    $('.number-valide-with-two-digit').keypress(function(event) {
        var $this = $(this);
        if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
           ((event.which < 48 || event.which > 57) &&
           (event.which != 0 && event.which != 8))) {
               event.preventDefault();
        }
        var text = $(this).val();
        if ((event.which == 46) && (text.indexOf('.') == -1)) {
            setTimeout(function() {
                console.log($this.val().length);
                if($this.val().length < 9){
                    if ($this.val().substring($this.val().indexOf('.')).length > 3) {
                        $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
                    }
                }
            }, 1);
        }
        if ((text.indexOf('.') != -1) &&
            (text.substring(text.indexOf('.')).length > 2) &&
            (event.which != 0 && event.which != 8) &&
            ($(this)[0].selectionStart >= text.length - 2)) {
                event.preventDefault();
        }      
    });
    $('.number-valide-with-two-digit').bind("paste", function(e) {
        var text = e.originalEvent.clipboardData.getData('Text');
        if ($.isNumeric(text)) {
            if ((text.substring(text.indexOf('.')).length > 3) && (text.indexOf('.') > -1)) {
                e.preventDefault();
                var pasteNumber = text.substring(0, text.indexOf('.') + 3);
                // remove extra number more than 9
                var numberLenght = pasteNumber.length;
                if(numberLenght > 9){
                    var reduceNumber = 9 - numberLenght;
                    pasteNumber = pasteNumber.slice(0, reduceNumber);
                }
                $(this).val(pasteNumber);
            }
        }
        else {
            e.preventDefault();
        }
    });
});