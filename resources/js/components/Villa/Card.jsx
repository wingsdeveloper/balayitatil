import React from 'react'

export default function Card(props) {
    let villa = props.villa;
    if (villa.desktop == true) {
        return (
            <div className="P_villas-item item-3 flex">
                <a href={villa.seo_url} className="global_link"></a>

                {
                    villa.tag ?
                        <div className="Badge" style={{backgroundColor: villa.tag.color}}>
                            <span>{villa.tag.name}</span>
                        </div>
                        : ''
                }

                <span className="P_villas-locasyon">
                <svg className="icon icon-point" data-original-title="" title="">
                    <use href="#icon-point"></use>
                </svg>
                    {
                        villa.area.name ? (villa.area_name ? villa.area_name : villa.area.name) : ''
                    }
            </span>
                <div className="P_villas-img ">
                    <img src={villa.resim} className="w-100"
                         alt={villa.name}/></div>
                <div className="P_villas-info">
                    <div className="P_villas-info-kod">
                        <span>Villa Kodu: VKV{villa.code}</span>
                        <p>{villa.name}</p>
                    </div>

                    <div className="P_villas-info-in">
                        <div className="info mobile-f">
                            <svg className="icon icon-point" data-original-title="" title="">
                                <use href="#icon-point"></use>
                            </svg>
                            <span>{villa.area_name ? villa.area_name : villa.area.name}</span>
                        </div>
                        <div className="info">
                            <svg className="icon icon-bed" data-original-title="" title="">
                                <use href="#icon-bed"></use>
                            </svg>
                            <span>{villa.number_bedroom} Yatak Odası</span>
                        </div>
                        <div className="info">
                            <svg className="icon icon-shower" data-original-title="" title="">
                                <use href="#icon-shower"></use>
                            </svg>
                            <span>{villa.number_bathroom} Banyo</span>
                        </div>
                        <div className="info">
                            <svg className="icon icon-user" data-original-title="" title="">
                                <use href="#icon-user"></use>
                            </svg>
                            <span>{villa.number_person} Kişilik</span>
                        </div>
                    </div>

                    <div className="P_villas-info-money  P_villas-info-money-account ">
                        <svg className="icon icon-wallet " data-original-title="" title="">
                            <use href="#icon-wallet"></use>
                        </svg>
                        <div className="flex-column">
                            <span>{villa.gece_sayisi} GECE</span>
                            <p>{villa.start_date} - {villa.end_date}</p>
                            <h6>{villa.toplam} ₺</h6>
                        </div>
                    </div>

                    <div className="P_villas-info-link">
                        Detaylı İncele
                        <svg className="icon icon-right-arrow " data-original-title="" title="">
                            <use href="#icon-right-arrow"></use>
                        </svg>
                    </div>
                </div>
            </div>
        )
    } else {
        return (
            <div className="VillasM flex wrap mobile">
                <div className="f_item">
                    <a href={villa.seo_url} className="global_link"></a>
                    <div className="f_item-image"><img src={villa.resim} className="w-100" alt={villa.name}/><p
                        className="f_item-kod flex-column"><span>VKV{villa.code}</span>{villa.name}</p></div>
                    <div className="f_item-info">
                        <span className="f_item-info-item"><svg className="icon icon-point "><use
                            href="#icon-point"></use></svg>
                            {villa.area_name ? villa.area_name : villa.area.name}</span>
                        <span className="f_item-info-item">
                        <svg className="icon icon-user "><use href="#icon-user"></use></svg>
                            {villa.number_person} Kişilik</span>
                        <div className="P_villas-info-money">
                            <svg className="icon icon-wallet ">
                                <use href="#icon-wallet"></use>
                            </svg>
                            <div className="flex-column">
                                <h6>{villa.toplam} ₺</h6>
                                <p>{villa.gece_sayisi} GECE</p>
                                <span>{villa.start_date} - {villa.end_date}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )

    }
}
