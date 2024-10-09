
function getDiseaseLink(disease) {
    switch (disease) {
        case "Common Cold":
            return "https://www.who.int/publications/i/item/WHO_FCH_CAH_01.02";
        case "Diarrhea":
            return "https://www.who.int/news-room/fact-sheets/detail/diarrhoeal-disease";
        case "Pneumonia":
            return "https://www.who.int/news-room/fact-sheets/detail/pneumonia";
        case "Hypertension":
            return "https://www.who.int/news-room/fact-sheets/detail/hypertension";
        case "Influenza":
            return "https://www.who.int/news-room/fact-sheets/detail/influenza-(seasonal)";
        case "Asthma":
            return "https://www.who.int/news-room/fact-sheets/detail/asthma";
        case "Dengue":
            return "https://www.who.int/news-room/fact-sheets/detail/dengue-and-severe-dengue";
        case "Cardiovascular Disease":
            return "https://www.who.int/news-room/fact-sheets/detail/cardiovascular-diseases-(cvds)";
        case "Tuberculosis":
            return "https://www.who.int/news-room/fact-sheets/detail/tuberculosis";
        case "Typhoid Fever":
            return "https://www.who.int/news-room/fact-sheets/detail/typhoid";
        case "Foodborne Disease":
            return "https://www.who.int/health-topics/foodborne-diseases#tab=tab_1";
        case "Diabetes":
            return "https://www.who.int/news-room/fact-sheets/detail/diabetes";
        case "Rabies":
            return "https://www.who.int/news-room/fact-sheets/detail/rabies";
        case "Hepatitis":
            return "https://www.who.int/health-topics/hepatitis#tab=tab_1";
        case "Migraine":
            return "https://www.who.int/news-room/fact-sheets/detail/headache-disorders";
        case "Cancer":
            return "https://www.who.int/health-topics/cancer#tab=tab_1";
        case "Measles":
            return "https://www.who.int/news-room/fact-sheets/detail/measles";
        case "Cholera":
            return "https://www.who.int/news-room/fact-sheets/detail/cholera";
        case "Malaria":
            return "https://www.who.int/news-room/fact-sheets/detail/malaria";
        case "HIV":
            return "https://www.who.int/news-room/fact-sheets/detail/hiv-aids";
        default:
            return "#"; // Default case if no match
    }
}
