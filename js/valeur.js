tableau();

function tableau(response){

    // Initialisation de Variable
    let t0 = [0, 0, 0, 0, 0, 0];
    let t1 = [0, 0, 0, 0, 0, 0];
    let t2 = [0, 0, 0, 0, 0, 0];
    let t3 = [0, 0, 0, 0, 0, 0];
    let t4 = [0, 0, 0, 0, 0, 0];
    let t5 = [0, 0, 0, 0, 0, 0];

    let tt =   [[0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0]];

    //Debut
    // Initialisation de Varaible 2
    let respiration = 20;
    let duree = 35;
    let profondeur = 25;
    let vit_desc = 20;
    let vit_asc = 10;
    let bar_init = 200;
    let vol_init = 3000;
    let pallile_t = 5;
    let pallile_m = 3;

    tt =   [[0, 0, calculPression(0), 0, bar_init, vol_init],
            [profondeur, 0, calculPression(profondeur/2), 0, 0, 0],
            [profondeur, duree, calculPression(profondeur), 0, 0, 0],
            [pallile_m, 0, calculPression((profondeur-pallile_m)/2), 0, 0, 0],
            [pallile_m, pallile_t, calculPression(pallile_m), 0, 0, 0],
            [0, 0, calculPression(0), 0, 0, 0]];

    // Creation tableau

    console.log(tt[1][0]);

    t1 = [profondeur, profondeur/vit_desc, calculPression(profondeur/2), 0, 0, 0];
    t1[3] = calculConsomation(respiration, t1[1], t1[2]);
    t1[5] = t0[5] - t1[3] ;
    t1[4] = calculBarRestante(t1[5], vol_init, bar_init);

    t2 = [ profondeur, duree, calculPression(profondeur), 0, 0, 0];
    t2[3] = calculConsomation(respiration, t2[1], t2[2]);
    t2[5] = t1[5] - t2[3];
    t2[4] = calculBarRestante(t2[5], vol_init, bar_init);

    t3 = [ pallile_m, (profondeur-pallile_m)/vit_asc, calculPression((profondeur-pallile_m)/2), 0, 0, 0];
    t3[3] = calculConsomation(respiration, t3[1], t3[2]);
    t3[5] = t2[5] - t3[3];
    t3[4] = calculBarRestante(t3[5], vol_init, bar_init);

    t4 = [ pallile_m, pallile_t, calculPression(pallile_m), 0, 0, 0];
    t4[3] = calculConsomation(respiration, t4[1], t4[2]);
    t4[5] = t3[5] - t4[3];
    t4[4] = calculBarRestante(t4[5], vol_init, bar_init);

    t5 = [ 0, (pallile_m)/vit_asc, calculPression(0), 0, 0, 0];
    t5[3] = calculConsomation(respiration, t5[1], t5[2]);
    t5[5] = t4[5] - t5[3];
    t5[4] = calculBarRestante(t5[5], vol_init, bar_init);

    console.log("tt : " + tt);

}

function calLigne(){



}

function calculPression(n){

    return ( n / 10 ) + 1;

}

function calculConsomation(a, b, c){

    return a*b*c ;

}

function calculBarRestante(n, vol_init, bar_init){

    return ( n * bar_init ) / vol_init;

}

