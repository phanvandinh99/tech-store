document.addEventListener("DOMContentLoaded", function () {
    var province = document.getElementById("province");

    window.onload = function () {
        $.ajax({
            url: 'https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/province',
            headers: {
                'token': '7962a838-fc48-11eb-b5ad-92f02d942f87',
                'Content-Type': 'application/json'
            },
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log('succes: ');
                console.log('dinh dinh ', province)
                console.log(response.data)
                var str = "<option selected> Chọn Tỉnh Thành </option>";
                for (var i = 0; i < response.data.length; i++) {
                    console.log(response.data[i].ProvinceName);
                    // str=str+"<option class='provinceId data-province'"+ response.data[i].ProvinceID+ "'>" + response.data[i].ProvinceName + "</option>"
                    str = str + "<option class='provinceId' data-province='"+ response.data[i].ProvinceID + "' value ='"+ response.data[i].ProvinceName +"' >" + response.data[i].ProvinceName + "</option>"

                }
                province.innerHTML = str;

            }
        });
    }
}, false)
function changeFunc() {
    var selectBox = document.getElementById("province");
    var selectedValue = selectBox.options[selectBox.selectedIndex].getAttribute('data-province');
    console.log('Gias tri: ', selectedValue);
    var district = document.getElementById('district');
    $.ajax({
        url: 'https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/district',
        headers: {
            'token': '7962a838-fc48-11eb-b5ad-92f02d942f87',
            'Content-Type': 'application/json'
        },
        method: 'GET',
        dataType: 'json',
        success: function (response) {


            var str = "<option selected> Chọn Quận / Huyện </option>";
            for (var i = 0; i < response.data.length; i++) {
                if (response.data[i].ProvinceID == selectedValue) {
                    //console.log(response.data[i]);
                    str = str + "<option class='districtId' data-district='" + response.data[i].DistrictID + "' value ='"+ response.data[i].DistrictName +"'>" + response.data[i].DistrictName + "</option>"
                }
            }
            district.innerHTML = str;

        }
    });

};
// chon xa 
function changeFuncDistrict(){
    var selectBox = document.getElementById("district");
    var selectedValue = selectBox.options[selectBox.selectedIndex].getAttribute('data-district');
    var ward  = document.getElementById('ward');
    $.ajax({
        url: 'https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/ward?district_id='+selectedValue,
        headers: {
            'token': '7962a838-fc48-11eb-b5ad-92f02d942f87',
            'Content-Type': 'application/json'
        },
        method: 'GET',
        dataType: 'json',
     success: function (response) {
            var str = "<option selected> Chọn Phường Xã </option>";
            for (var i = 0; i < response.data.length; i++) {
                  str = str + "<option class='wardId' data-ward='" + response.data[i].WardCode + "' value ='"+ response.data[i].WardName +"'>" + response.data[i].WardName + "</option>"
}
            ward.innerHTML = str;

        }
    });
};