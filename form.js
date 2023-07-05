let prefectureToAreas = {
    tokyo: ["23区内", "23区外"],
    kanagawa: ["横浜市", "川崎市", "相模原市", "神奈川県のその他地域"]
};

let areaToCities = {
    "23区内": ["千代田区", "中央区", "港区", ".."],
    "23区外": ["八王子市", "立川市", "..."],
    "横浜市": ["北区", "都島区", "..."],
    "川崎市": ["堺市", "枚方市", "..."]
};

function updateAreas() {
    let prefectureSelect = document.getElementById('prefecture');
    let areaSelect = document.getElementById('area');
    
    // 既存のオプションを削除
    while (areaSelect.options.length > 0) {
        areaSelect.remove(0);
    }
    
    // 選択した都道府県に基づいて地域を追加
    let areas = prefectureToAreas[prefectureSelect.value];
    if (areas) {
        areas.forEach(function(area) {
            let option = new Option(area, area);
            areaSelect.appendChild(option);
        });
    }

    updateCities(); // 地域の選択が変更された時に市区町村も更新する
}

function updateCities() {
    let areaSelect = document.getElementById('area');
    let cityDiv = document.getElementById('city');
    
    // 既存のチェックボックスを削除
    while (cityDiv.children.length > 1) {
        cityDiv.removeChild(cityDiv.lastChild);
    }
    


    let cities = areaToCities[areaSelect.value];
if (cities) {
    cities.forEach(function(city, index) {
        let checkbox = document.createElement('div');
        checkbox.className = "form-check";
        checkbox.innerHTML = `
            <input class="form-check-input" type="checkbox" value="${city}" id="city${index}" name="city[]">
            <label class="form-check-label" for="city${index}">
                ${city}
            </label>
        `;
        cityDiv.appendChild(checkbox);
    });
}
}
