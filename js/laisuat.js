jQuery(document).ready(function ($) {

$('#devvn_nhomxe').on('change', function() {
    updateAmount();
});
$('#devvn_phienbanxe').on('change', function() {
    updateAmount();
});
$('#devvn_chonnoimua').on('change', function() {
    updateAmount();
});

$('.show').on('click', function() {
    $('.result-body').html('');
    updatePanel();
});
function h(a, n, t, e) {
            a = (a + "").replace(/[^0-9+\-Ee.]/g, "");
            var o, i, h, v = isFinite(+a) ? +a : 0,
                l = isFinite(+n) ? Math.abs(n) : 0,
                r = void 0 === e ? "." : e,
                d = void 0 === t ? "," : t,
                c = "";
            return 3 < (c = (l ? (o = v, i = l, h = Math.pow(10, i), "" + Math.round(o * h) / h) : "" + Math.round(v)).split("."))[0].length && (c[0] = c[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, r)), (c[1] || "").length < l && (c[1] = c[1] || "", c[1] += new Array(l - c[1].length + 1).join("0")), c.join(d)
        }
function updateAmount() {
    var a = n = parseInt($("#devvn_phienbanxe").val() || 1),
                t = parseInt($("#devvn_chonnoimua :selected").val() || 1),
                e = parseInt($("#devvn_phienbanxe :selected").data("phitruocba") || 0);
            if (n) {
                var o = parseInt(n * devvn_muaoto_array.bao_hiem_vat_chat / 100);
                $("#baohiemvatchat_val").val(o), $("#phitruocba_val").val(e);
                var i = 0;
                $(".input_to_calc").each(function() {
                    i += parseInt($(this).val())
                }), $("#total").val((isNaN(i)) ? 0 : i),$("#amount_txt").val((isNaN(i)) ? 0 : h(i) + " VNĐ")
            } else alert("Vui lòng chọn phiên bản xe hoặc phiên bản xe bạn chọn không có giá bán.")
}

function updatePanel() {
    calServiceFees();
}
function daysInMonth(month,year) {
    return new Date(year, month, 0).getDate();
}

function calServiceFees() {
            
            $('.total_price').html('<div id="rotatingDiv"></div>');
            var months = new Array( "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12");

            var prepaid = parseInt($("#first_price :selected").val() || 0);
            var total = parseInt($('#total').val() || 0);
            var amount = total-(total*prepaid/100);

            var LS = $('#rate').val();
            var G = amount;
            var M = $('#month').val();
            var now = new Date();
            var d = new Date();

            var month = d.getMonth()+1;
            var day = d.getDate();

            var output = (day<10 ? '0' : '') + day + '/' +
                (month<10 ? '0' : '') + month + '/' +
                d.getFullYear(); 
            
            var N = daysInMonth(months[now.getMonth()],now.getFullYear());

            var tonglai = 0;
            var goc = amount;

            var GM = Math.ceil(G/M);

            

            $('.ky-thanh-toan').html(output);
            $('.amount-start').html(h(G));


            $('<tr><td>0</td><td class="ky-thanh-toan">' + output + '</td><td></td><td class="amount-start">' + h(G) + ' VNĐ</td><td></td><td></td><td></td></tr>').appendTo($('.result-body'));

            for (i = 1; i <= M; i++) { 
                $total = Math.round(eval("(" + congthuc + ")"));
                $total = $total/100;

                var permonth = GM + $total;
                var parts = output.split("/");
                var d  = new Date(parts[2], parts[1] - 1, parts[0]);
                var n  = new Date(parts[2], parts[1], parts[0]);
                var month = d.setMonth(d.getMonth() + 1, 1);
                month = months[d.getMonth()];
                var nmonth = n.setMonth(n.getMonth() - 1, 1);
                N = daysInMonth(months[n.getMonth()],n.getFullYear());
                
                output = (day<10 ? '0' : '') + day + '/' +
                (month<10 ? '0' : '') + month + '/' +
                d.getFullYear();

                permonth = Math.ceil(permonth);
                permonth = h(permonth);
                $total = Math.ceil($total);
                tonglai = tonglai + $total;
                $total = h($total);
                G = G-GM;
                if(G<0) { G = 0; }
                
                $('<tr><td>'+i+'</td><td class="ky-thanh-toan' + i + '">'+output+'</td><td>' + N + '</td><td class="amount-start">' + h(G) + ' VNĐ</td><td>' + h(GM) + ' VNĐ</td><td>' + $total + ' VNĐ</td><td>' + permonth + ' VNĐ</td></tr>').appendTo($('.result-body'));
            }

            $('.tong-lai-gop').html(h(tonglai) + " VNĐ");
            $('.tong-goc-lai-gop').html(h(tonglai + goc) + " VNĐ");
        }
});



