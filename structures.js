
var villages = {
    _id: MongoId(),
    owner_id: ObjectId(), // --> owners._id
    vhid: '44040102',
    survey: {
        ntraditional: 1,
        nmonk: 2,
        nreligionleader: 2,
        nbroadcast: 1,
        nradio: 0,
        npchc: 1,
        nclinic: 1,
        ndrugstore: 1,
        nchildcenter: 0,
        npschool: 1,
        nsschool: 1,
        ntemple: 1,
        nreligiousplace: 1,
        nmarket: 1,
        nshop: 0,
        nfoodshop: 1,
        nstall: 0,
        nraintank: 2,
        nchickenfarm: 2,
        npigfarm: 1,
        wastewater: 2,
        garbage: 1,
        nfactory: 1,
        latitude: 1525520.1255,
        longitude: 0.22554522,
        outdate: '20120508',
        numactually: 0,
        risktype: 0,
        numstateless: 0,
        nexerciseclub: 2,
        nolderlyclub: 1,
        ndisableclub: 1,
        nnumberoneclub: 2
    },
    houses: [ // Array
        {
            hid: 123456, // auto number
            house_id: '44040105',
            house_type: '1',
            room_no: '501',
            condo_name: 'หอพักตักศิลา',
            address: '45/1',
            soisub: null,
            soimain: null,
            road: 'ถีนานนท์',
            village_name: null,
            telephone: null,
            latitude: 415526.0012,
            longitude: 4522.001155,
            family: [1, 2],
            location_type: '1',
            vhvid: MongoId(),
            headid: MongoId(),
            toilet: '1',
            water: '2',
            water_type: '',
            garbage: '',
            housing: '',
            durability: '',
            cleanliness: '',
            ventilation: '',
            light: '',
            watertm: '',
            mfood: '',
            bcontrol: '',
            acontrol: '',
            chemical: '',
            outdate: '',
            last_update: '2012-02-28 15:32:41'
        }
    ],

    community_activities: [
        {
            date_start: '',
            date_finish: '',
            comactivity: ObjectId(),
            provider_id: ObjectId(),
            user_id: ObjectId(),
            last_update: ''
        }
    ],

    last_update: '2012-02-28 15:32:41'
}; // End villages
/**
 * Person schema
 */
var person = {
    _id: ObjectId(),
    owner_id: ObjectId(), // --> owners._id
    hn: '560000001',
    house_id: ObjectId(), // --> villages.houses.hid
    title: '001',
    first_name: 'พรชัย',
    last_name: 'มงคลชัย',
    sex: '1',
    birth_date: '20010225',
    mstatus: '1',
    occupation: ObjectId(), // --> ref_occupations._id
    race: ObjectId(), // --> ref_races._id
    nation: ObjectId(), // --> ref_nations._id
    religion: ObjectId(), // --> ref_religions._id
    education: ObjectId(), // --> ref_educations._id
    fstatus: '2',
    father_cid: '',
    mother_cid: '',
    couple_cid: '',
    vstatus: '2',
    movein_date: '',
    discharge_status: '2',
    discharge_date: '20120202',
    abogroup: '1',
    rhgroup: '1',
    labor: ObjectId(), // --> ref_labor_types._id
    passport: '',
    typearea: '1',
    death: { // Object
        hospdeath: '',
        an: '',
        seq: '',
        ddeath: '',
        cdeath_a: '',
        cdeath_b: '',
        cdeath_d: '',
        odisease: '',
        cdeath: '',
        pregdeath: '',
        pdeath: '',
        provider: '',
        last_update: '2012-05-31 12:25:15'
    },
    chronic: [ // Array
        {
            diag: '',
            date_diag: '',
            hosp_dx: '',
            hosp_rx: '',
            date_disch: '',
            typedisch: '',
            last_update: ''
        }
    ],
    card: { //Object
        instype: ObjectId(),
        insid: '',
        start_date: '',
        expire_date: '',
        hmain: '',
        hsub: '',
        work: '',
        last_update: ''
    },

    clinic_members: [ // Array
        {
            code: '01',
            register_date: '',
            owner_id: ObjectId(),
            user_id: ObjectId()
        }
    ],

    drugallergies: [ // Array
        {
            date_record: '',
            did: '',
            typedx: '',
            alevel: '',
            symptom: '',
            informant: '',
            informhosp: '',
            user_id: ObjectId(),
            last_update: ''
        }
    ],

    last_update: '2012-05-31 12:25:15'
}; //End person

var services = {
    owner_id: ObjectId(),
    user_id: ObjectId(),
    vn: '',
    hn: '',
    date_serv: '',
    time_serv: '',
    clinic: '',
    location: '',
    intime: '',
    instype: ObjectId(),
    insid: '',
    hmain: '',
    hsub: '',
    work: '',
    typein: '',

    screening: {
        cc: '',
        weight: 25,
        height: 150,
        bmi: 0.254,
        waist: 25.00,
        btemp: '',
        bps: [ // Array
            {
                sbp: 180,
                dbp: 20
            }
        ],
        pr: '',
        rr: '',
        last_lmp: ''
    },
    refer_in: {
        hospcode: '',
        cause: ''
    },
    refer_out: {
        hospcode: '',
        cause: ''
    },
    service_place: '',
    typeout: '',

    // Activities
    diagnosis: [ // Array
        {
            diag: '',
            diag_type: '',
            clinic_id: ObjectId(),
            provider_id: ObjectId(),
            last_update: ''
        }
    ],

    procedures: [ // Array
        {
            proced: '',
            price: 0.0,
            start_time: '',
            end_time: '',
            clinic_id: ObjectId(),
            provider_id: ObjectId(),
            last_update: ''
        }
    ],

    appointments: [ // Array
        {
            clinic_id: ObjectId(),
            apdate: '',
            aptype: '',
            apdiag: '',
            provider_id: ObjectId(),
            last_update: ''
        }
    ],

    accident: {
        datetime_ac: '',
        aetype: '',
        aeplace: '',
        typein_ae: '',
        traffic: '',
        vehicle: '',
        alcohol: '',
        nacrotic_drug: '',
        belt: '',
        helmet: '',
        airway: '',
        stopbleed: '',
        splint: '',
        fluid: '',
        urgency: '',
        coma_eye: '',
        coma_speak: '',
        coma_movement: '',
        user_id: ObjectId(),
        last_update: ''
    },

    surveillances: [ // Array
        {
            syndrome: ObjectId(),
            diagcode: '',
            code506: '',
            diagcode_last: '',
            code506_last: '',
            illdate: '',
            illhouse: '',
            illvillage: '',
            illtambon: '',
            illampur: '',
            illchangwat: '',
            latitude: '',
            longitude: '',
            school_name: '',
            school_class: '',
            ptstatus: '',
            date_death: '',
            complication: ObjectId(),
            organism: ObjectId(),
            provider_id: ObjectId(),
            user_id: ObjectId(),
            last_update: ''
        }
    ],

    drugs: [ // Array
        {
            drug_id: ObjectId(),
            clinic_id: ObjectId(),
            qty: 0,
            price: 0.00,
            usage_id: ObjectId(),
            provider_id: ObjectId(),
            user_id: ObjectId()
        }
    ],

    charges: [ // Array
        {
            charge_id: ObjectId(),
            qty: 0,
            price: 0.0,
            user_id: ObjectId(),
            instype: ObjectId()
        }
    ],

    dental: {
        denttype: '',
        pteeth: 0,
        pcaries: 0,
        pfilling: 0,
        pextract: 0,
        dteeth: 0,
        dcaries: 0,
        dfilling: 0,
        dextract: 0,
        need_fluoride: '',
        need_scaling: '',
        need_sealant: 0,
        need_pfillng: 0,
        need_dfilling: 0,
        need_pextract: 0,
        need_dextract: 0,
        nprosthesis: '',
        permanent_perma: 0,
        permanent_prost: 0,
        prosthesis_prost: 0,
        gum: '',
        schooltype: '',
        class: '',
        provider_id: ObjectId(),
        user_id: ObjectId(),
        last_update: ''
    },

    chronicfu: {
        foot: '',
        eye: '',
        provider_id: ObjectId(),
        user_id: ObjectId()
    },

    labs: {
        lab_id: ObjectId(),
        lab_result: '',
        user_id: ObjectId(),
        provider_id: ObjectId(),
        last_update: ''
    },

    community_service: [
        {
            comservice: ObjectId(),
            provider_id: ObjectId(),
            user_id: ObjectId()
        }
    ],

    last_update: ''
}; // End services

// การดูแลก่อนคลอดและหลังคลอด
var pregnancies = [
    {
        hn: '5600000014',
        owner_id: ObjectId(),
        gravida: '01', // 1 คนสามารถมีได้หลาย Record ถ้า gravida คนละครั้ง
        prenatal: {
            lmp: '',
            edc: '', // LMP + 40 week
            vdrl_result: '',
            hb_result: '',
            hiv_result: '',
            date_hct: '',
            hct_result: '',
            thalassemia: '',
            last_update: '',
            export: 'Y',
            export_date: '',
            provider_id: ObjectId(),
            user_id: ObjectId()
        },
        anc: {
            services: [
                {
                    vn: '',
                    date_serv: '',
                    ga: 12,
                    ancresult: '',
                    ancplace: '',
                    provider_id: ObjectId(),
                    user_id: ObjectId(),
                    last_update: ''
                }
            ],
            covers: [
                {
                    date_serv: '',
                    ga: 12,
                    ancresult: '',
                    ancplace: '',
                    user_id: ObjectId(),
                    last_update: ''
                }
            ]
        },

        labor: {
            bdate: '',
            btime: '',
            bresult: '',
            bplace: '',
            bhosp: '',
            btype: '',
            bdoctor: '',
            lborn: 1,
            sborn: 0,
            ga: 40,
            last_update: ''
        },

        postnatal: {
            services: [
                {
                    vn: '',
                    date_serv: '',
                    place: '',
                    result: '',
                    provider_id: ObjectId(),
                    user_id: ObjectId(),
                    last_update: ''
                }
            ],
            covers: [
                {
                    date_serv: '',
                    place: '',
                    result: '',
                    user_id: ObjectId(),
                    last_update: ''
                }
            ]
        },

        //Babies
        babies: ['56000001']
    }
];

var babies = [
    {
        owner_id: ObjectId(),
        hn: '56000001',
        mother_hn: '',
        birth_no: 1,
        bweight: 3000.00,
        asphyxia: '',
        vitk: '',
        tsh: '',
        tshresult: '',
        user_id: ObjectId(),
        services: [ // Array
            {
                vn: '',
                date_serv: '',
                place: '',
                result: '',
                food: '',
                provider_id: ObjectId(),
                user_id: ObjectId()
            }
        ],

        covers: [ // Array
            {
                date_serv: '',
                place: '',
                result: '',
                food: '',
                user_id: ObjectId()
            }
        ]
    }
]
