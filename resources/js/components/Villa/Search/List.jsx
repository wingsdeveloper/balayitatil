import React, {Component} from "react";
import Card from "../Card";
import ReactDOM from "react-dom";
import Skeleton, {SkeletonTheme} from 'react-loading-skeleton';
import Pagination from "react-js-pagination";
import scrollTo from 'gatsby-plugin-smoothscroll';
import {withRouter} from 'react-router-dom';

class VillaSearchList extends Component {
    /*oncelikle CARD itemlerinin icinin doldurulabilmesi iicn verilerin getirilmesi gerekmektedir.*/

    constructor(props) {
        super(props);
        this.params = {};
        this.state = {
            userParameters: props.userParameters,
            isFetching: true,
            text: null,
            orderBy: null,
            activePage: props.userParameters.activePage,
            total: props.userParameters.total,
            siralama: null,
            selectedArea: props.userParameters.area,
            districts: null,
            selectedDistrict: null,
            price: null
        };

        this.handlePageChange = this.handlePageChange.bind(this);
        this.handleOrderByChange = this.handleOrderByChange.bind(this);
        this.handlePriceChange = this.handlePriceChange.bind(this);
        this.handleAreaChange = this.handleAreaChange.bind(this);
        this.getFixedBar = this.getFixedBar.bind(this);
        this.handlePopState = this.handlePopState.bind(this);
        this.getFilter = this.getFilter.bind(this);
        this.handleDistrictChange = this.handleDistrictChange.bind(this);
        this.fetchDistricts = this.fetchDistricts.bind(this);
    }

    handlePopState(event) {
        event.preventDefault();

        const urlParams = new URLSearchParams(window.location.search);
        let sayfa = urlParams.get('sayfa');
        let orderBy = urlParams.get('siralama')
        let area = urlParams.get('bolge')
        let district = urlParams.get('mahalle')
        let price = urlParams.get('fiyat')


        if (sayfa == null) {
            sayfa = 1
        }
        if(district == null) {
            district = 0
        }
        if(price == null) {
            price = null
        }

        this.setState({
            activePage: parseInt(sayfa),
            isFetching: true,
            orderBy: orderBy,
            area: area,
            district: district,
            selectedArea: area,
            selectedDistrict:  district
        });
        let parameters = this.props.userParameters;
        parameters.activePage = parseInt(sayfa);
        parameters.orderBy = orderBy;
        parameters.selectedArea = area;
        parameters.selectedDistrict = district;
        parameters.bolge = area;
        parameters.mahalle = district;
        parameters.area = area;
        parameters.district = district;
        parameters.price = price;
        const query = this.getQueryString(parameters);
        this.setState({params: parameters})
        this.fetchProperties(query)


    }

    componentDidMount() {
        window.onpopstate = this.handlePopState;
        const parameters = this.getQueryString(this.props.userParameters);
        console.log(this.props.userParameters)
        fetch('/ajax-get/areas').then(response => response.json()).then(data => {
            this.setState({areas: data})
        }).then(() => {
            if (this.state.selectedArea != null) {
                this.fetchDistricts(this.state.selectedArea);
            }

        }).then(() => {
            $('select[name="bolge"]').selectpicker('refresh');
        });
        fetch(this.props.searchRoute + '?' + parameters).then(response => response.json()).then(data => {
            if (data.success == true) {
                let array = [];
                array = Object.values(data.villas);
                this.setState({villas: (array), isFetching: false, total: data.count})
                if (this.state.siralama == null) {
                    this.getFilter();
                }
            } else {
                this.setState({villas: null, isFetching: false, total: null})
            }
        });
    }

    componentWillUnmount() {
        window.onpopstate = null;
    }

    handlePageChange(pageNumber) {

        this.setState({activePage: pageNumber, isFetching: true});

        const url = new URL(window.location);
        url.searchParams.set('sayfa', pageNumber);
        window.history.pushState({}, '', url);

        let parameters = this.props.userParameters;
        parameters.activePage = pageNumber;
        const query = this.getQueryString(parameters);
        this.setState({params: parameters})
        this.fetchProperties(query)
    }

    handleOrderByChange(e) {
        scrollTo(".Villas-filter")
        this.setState({
            orderBy: e.target.value,
            isFetching: true
        })

        const url = new URL(window.location);
        url.searchParams.set('siralama', e.target.value);
        window.history.pushState({}, '', url);

        let parameters = this.props.userParameters;
        parameters.orderBy = e.target.value;

        const query = this.getQueryString(parameters);

        this.fetchProperties(query)

    }

    handlePriceChange(e) {
        scrollTo(".Villas-filter")
        this.setState({
            price: e.target.value,
            isFetching: true
        })

        const url = new URL(window.location);
        url.searchParams.set('fiyat', e.target.value);
        window.history.pushState({}, '', url);

        let parameters = this.props.userParameters;
        parameters.price = e.target.value;

        const query = this.getQueryString(parameters);

        this.fetchProperties(query)

    }

    handleAreaChange(e) {
        scrollTo(".Villas-filter")
        this.setState({
            area: e.target.value,
            selectedArea: e.target.value,
            isFetching: true
        })
        const url = new URL(window.location);
        url.searchParams.set('bolge', e.target.value);
        window.history.pushState({}, '', url);

        let parameters = this.props.userParameters;
        parameters.area = e.target.value;
        const query = this.getQueryString(parameters);

        this.fetchDistricts(e.target.value)
        this.fetchProperties(query)
    }

    handleDistrictChange(e) {
        scrollTo(".Villas-filter")
        this.setState({
            district: e.target.value,
            isFetching: true
        })

        const url = new URL(window.location);
        url.searchParams.set('mahalle', e.target.value);
        window.history.pushState({}, '', url);

        let parameters = this.props.userParameters;
        parameters.district = e.target.value;

        const query = this.getQueryString(parameters);

        this.fetchProperties(query)

    }

    getQueryString(queries) {

        return Object.keys(queries).reduce((result, key) => {
            return [...result, `${encodeURIComponent(key)}=${encodeURIComponent(queries[key])}`]
        }, []).join('&');
    };

    createElements(n) {
        var elements = [];
        let i = 0;
        for (i = 0; i < n; i++) {
            elements.push(
                <div
                    className={this.props.isDesktop == 'desktop' ? "P_villas-item item-3 flex" : 'VillasM flex wrap mobile'}>

                    <a className="global_link"></a>

                    <div className="P_villas-img ">
                        <img src={"/images/default.jpg"} className="w-100"/></div>
                    <div className="P_villas-info">
                        <div className="P_villas-info-kod">
                            <Skeleton style={{width: "60%"}} count={1}/>
                            <p><Skeleton style={{width: "80%"}} count={1}/></p>
                        </div>

                        <div className="P_villas-info-in">
                            <div className="info mobile-f">
                                <svg className="icon icon-point" data-original-title="" title="">
                                    <use href="#icon-point"></use>
                                </svg>
                                <span><Skeleton count={1}/></span>
                            </div>
                            <div className="info">
                                <svg className="icon icon-bed" data-original-title="" title="">
                                    <use href="#icon-bed"></use>
                                </svg>
                                <Skeleton style={{width: "60%"}} count={1}/>
                            </div>
                            <div className="info">
                                <svg className="icon icon-shower" data-original-title="" title="">
                                    <use href="#icon-shower"></use>
                                </svg>
                                <Skeleton style={{width: "60%"}} count={1}/>
                            </div>
                            <div className="info">
                                <svg className="icon icon-user" data-original-title="" title="">
                                    <use href="#icon-user"></use>
                                </svg>
                                <Skeleton style={{width: "60%"}} count={1}/>
                            </div>
                        </div>

                        <div className="P_villas-info-money  P_villas-info-money-account ">
                            <svg className="icon icon-wallet " data-original-title="" title="">
                                <use href="#icon-wallet"></use>
                            </svg>
                            <div className="flex-column">
                                <span><Skeleton count={1}/></span>
                                <p><Skeleton count={1}/></p>
                                <h6><Skeleton count={1}/></h6>
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
            );
        }
        return elements;
    }


    getFilter() {
        this.setState({
            'siralama': (
                <select autoComplete="off" onChange={this.handleOrderByChange} name="siralama" className="selectpicker">
                    <option value="0">Sıralama Şeklini Seçiniz</option>
                    <option value="artan">Sıralama: Artan Fiyat</option>
                    <option value="azalan">Sıralama: Azalan Fiyat</option>
                </select>
            )
        })

    }

    getFixedBar() {
        let selectedArea = this.state.selectedArea;
        let selectedDistrict = this.state.selectedDistrict;
        let selectedPrice = this.state.price;
        return (
            <div className="Villas-filter flex a-i-c"
                 style={this.props.isDesktop == 'desktop' ? {'': ''} : {'flexDirection': 'column '}}>
                {
                    this.state.total ? <p><i className="fa fa-list-ul"></i> {this.state.total} Villa Listelendi</p> :
                        <p><i className="fa fa-list-ul"></i> Arama sonuçlarınız yükleniyor</p>
                }

                <div className="Villas-filter-item ml-auto">
                    <select autoComplete="off" onChange={this.handleAreaChange} name="bolge" className="selectpicker">
                        <option value="0">Bölge Seçiniz</option>
                        {
                            this.state.areas && this.state.areas.map(function (area, i) {
                                return <option selected={selectedArea == area.id} key={'area-item' + i}
                                               value={area.id}>{area.name}</option>;
                            })
                        }
                    </select>
                    <svg className="icon icon-caret-down addon">
                        <use href="#icon-caret-down"></use>
                    </svg>
                    <svg className="icon icon-caret-down addon">
                        <use href="#icon-caret-down"></use>
                    </svg>
                </div>
                <div className="Villas-filter-item"
                     style={this.props.isDesktop == 'desktop' ? {'marginLeft': '10px'} : {'marginLeft': 'auto'}}>
                    <select autoComplete="off" onChange={this.handleDistrictChange} name="district"
                            className="selectpicker">
                        <option value="0">Alt Bölge Seçiniz</option>
                        {
                            this.state.districts && this.state.districts.map(function (district, i) {
                                return <option selected={selectedDistrict == district.id} key={'district-item' + i}
                                               value={district.id}>{district.name}</option>;
                            })
                        }
                    </select>
                    <svg className="icon icon-caret-down addon">
                        <use href="#icon-caret-down"></use>
                    </svg>
                    <svg className="icon icon-caret-down addon">
                        <use href="#icon-caret-down"></use>
                    </svg>
                </div>
                <div className="Villas-filter-item"
                     style={this.props.isDesktop == 'desktop' ? {'marginLeft': '10px'} : {'marginLeft': 'auto'}}>
                    <select autoComplete="off" onChange={this.handlePriceChange} name="price"
                            className="selectpicker">
                        <option value="0">Fiyat Aralığı</option>
                        <option selected={selectedPrice == "1500"} value="1500">Gecelik 500-1500₺</option>
                        <option selected={selectedPrice == "3000"} value="3000">Gecelik 1500-3000₺</option>
                        <option selected={selectedPrice == "5000"} value="5000">Gecelik 3000-5000₺</option>
                        <option selected={selectedPrice == "5000+"} value="5000+">Gecelik 5000₺ Üzeri</option>
                    </select>
                    <svg className="icon icon-caret-down addon">
                        <use href="#icon-caret-down"></use>
                    </svg>
                    <svg className="icon icon-caret-down addon">
                        <use href="#icon-caret-down"></use>
                    </svg>
                </div>
                <div className="Villas-filter-item"
                     style={this.props.isDesktop == 'desktop' ? {'marginLeft': '10px'} : {'marginLeft': 'auto'}}>
                    <select autoComplete="off" onChange={this.handleOrderByChange} name="siralama"
                            className="selectpicker">
                        <option value="0">Sıralama Şeklini Seçiniz</option>
                        <option value="artan">Sıralama: Artan Fiyat</option>
                        <option value="azalan">Sıralama: Azalan Fiyat</option>
                    </select>
                    <svg className="icon icon-caret-down addon">
                        <use href="#icon-caret-down"></use>
                    </svg>
                    <svg className="icon icon-caret-down addon">
                        <use href="#icon-caret-down"></use>
                    </svg>
                </div>
            </div>
        );


    }

    fetchDistricts(area) {
        fetch('/ajax-get/' + area + '/districts').then(response => response.json()).then(data => {
            this.setState({districts: data})
        }).then(() => {
            if(this.props.userParameters.district) {
                this.setState({
                    selectedDistrict: this.props.userParameters.district
                })
            }
            $("select[name='district']").selectpicker('refresh');
        });

    }

    propertiesNotFound() {
        return (
            <section className="Villa_not">
                <div className="container">
                    <div className="Villa_not-in flex-column a-i-c mt-5">
                        <svg className="icon icon-agly" data-original-title="" title="">
                            <use href="#icon-agly"></use>
                        </svg>

                        <p className="header-md text-center">BELİRTTİĞİNİZ TARİHLER ARASINDA
                            <br/> KRİTERLERİNİZE UYGUN VİLLA BULAMADIK.
                        </p>
                        <p className="text-center ">
                            Seçtiğiniz kriterleri azaltabilir ya da konaklama süresini uzatarak(en az 5 gece)
                            tekrar arama yapabilirsiniz
                            <br/>veya sayfada bulunan WhatsApp butonuna tıklayarak ekibimizden canlı yardım
                            alabilirsiniz.
                        </p>
                        <br/>
                        <a href="/"
                           className="buton_orange p-0 mx-auto mt-2">
                            Anasayfaya Dön
                        </a>
                        <a href="/yaklasan-firsatlar"
                           className="buton_orange p-0 mx-auto mt-2">
                            Yaklaşan Fırsatları Görüntüle
                        </a>


                    </div>
                </div>
            </section>
        )
    }

    fetchProperties(query) {
        console.log(query);
        scrollTo(".Villas-filter")
        fetch(this.props.searchRoute + '?' + query).then(response => response.json()).then(data => {
            if (data.success == true) {
                let array = [];
                array = Object.values(data.villas);
                this.setState({villas: (array), isFetching: false, total: data.count})
                this.getFixedBar();
            } else {
                this.setState({villas: 'null', isFetching: false, total: null})
            }

        }).then(() => {
            $('.selectpicker').selectpicker('refresh')
        });
    }

    render() {
        if (this.state.isFetching == true) {
            return (
                <div className={" containerindex"}>
                    {this.getFixedBar()}
                    <div className={this.props.isDesktop == 'desktop' ? "Villas-in flex wrap desktop" : ''}>
                        {this.createElements(18)}
                    </div>
                </div>
            );
        } else {
            if (this.state.villas != null) {
                try {
                    return (
                        <div className={"containerindex"}>
                            {this.getFixedBar()}

                            <div className={this.props.isDesktop == 'desktop' ? "Villas-in flex wrap desktop" : ''}>
                                {
                                    this.state.villas && this.state.villas.map(function (villa, i) {
                                        return <Card villa={villa} key={'villa-item' + i}/>;
                                    })
                                }
                            </div>
                            <nav className={"flex j-c-c"}>
                                <Pagination
                                    prevPageText={'...'}
                                    nextPageText={'...'}
                                    activeLinkClass={"active"}
                                    activeClass={"active-parent"}
                                    linkClass={"page-link"}
                                    itemClass={"page-item"}
                                    activePage={this.state.activePage}
                                    itemsCountPerPage={18}
                                    totalItemsCount={this.state.total}
                                    pageRangeDisplayed={8}
                                    onChange={this.handlePageChange.bind(this)}
                                />
                            </nav>

                        </div>
                    );
                } catch (e) {
                    return this.propertiesNotFound()
                }

            } else {
                return this.propertiesNotFound()

            }

        }

    }
}

export default withRouter(VillaSearchList);
if (document.getElementById('Villas-list')) {
    const container = document.getElementById('Villas-list');
    const searchRoute = $(container).data('search-route');
    let categories = new String($(container).data('categories'))

    categories = categories.split(',');

    const userParameters = {
        startDate: $(container).data('start-date'),
        endDate: $(container).data('end-date'),
        person: $(container).data('person'),
        area: $(container).data('area'),
        orderBy: $(container).data('order-by'),
        activePage: $(container).data('active-page'),
        total: $(container).data('total-villa'),
        district: $(container).data('mahalle'),
        selectedCategories: categories,

    }
    ReactDOM.render(<VillaSearchList isDesktop={$(container).data('is-desktop')} userParameters={userParameters}
                                     searchRoute={searchRoute}/>, document.getElementById('Villas-list'));


}
