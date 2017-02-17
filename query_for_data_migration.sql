/*QUERY MIGRATE MASTER_KTP TO KTP*/
INSERT INTO ktp(ktp_nik,ktp_nama_lengkap,ktp_tempat_lahir,ktp_tanggal_lahir,ktp_jk,job_id,ktp_alamat,
religion_id,ms_id,sub_district_id,district_id,city_id,province_id)
SELECT master_ktp_nik,master_ktp_nama,master_ktp_tempat_lahir,master_ktp_tgl_lahir,master_jk_id,
master_pekerjaan_id,master_ktp_alamat,master_agama_id, master_status_nikah_id,master_kelurahan_id,
master_kecamatan_id,master_kota_kabupaten_id,master_provinsi_id
FROM master_ktp;
UPDATE ktp SET ktp_kewarganegaraan='WNI';

/*QUERY MIGRATE MASTER_BIODATA_PEGAWAI TO TR_PEGAWAI*/
INSERT INTO tr_pegawai(pg_id,ktp_nik,pg_nip,pg_no_telp,pg_no_hp,pg_email,jabatan_id)
SELECT master_biodata_pegawai.master_biodata_pegawai_id, master_ktp_nik,master_biodata_pegawai_nip,master_biodata_pegawai_no_telp,
master_biodata_pegawai_no_seluler,master_biodata_pegawai_email, mst_jabatan.`jabatan_id`
FROM master_biodata_pegawai 
LEFT JOIN pegawai_jabatan ON pegawai_jabatan.`master_biodata_pegawai_id`=master_biodata_pegawai.`master_biodata_pegawai_id`
LEFT JOIN mst_jabatan ON mst_jabatan.`jabatan_code`=pegawai_jabatan.`master_jabatan_id` 
GROUP BY master_biodata_pegawai.`master_biodata_pegawai_id`;
UPDATE tr_pegawai SET active='Y';

/*QUERY MIGRATE PENGADUAN_PERISTIWA JOIN PENGADUAN_PERBUATAN TO MC_PENGADUAN_PERISTIWA*/
INSERT INTO mc_pengaduan_peristiwa (pgdpp_id, pgd_id, pgdpp_tgl_kejadian, pgdpp_tempat_kejadian,pgdpp_perbuatan, subdistrict_id)
SELECT pengaduan_peristiwa.pengaduan_peristiwa_id, pengaduan_peristiwa.pengaduan_id,pengaduan_tgl_kejadian, 
pengaduan_tempat_kejadian,pengaduan_perbuatan_isi, master_kelurahan_id
FROM pengaduan_peristiwa
LEFT JOIN pengaduan_perbuatan ON pengaduan_perbuatan.`pengaduan_peristiwa_id`=pengaduan_peristiwa.`pengaduan_peristiwa_id`

/*QUERY MIGRATE MASTER_BIODATA_PERADILAN TO TR_PARA_PIHAK*/
INSERT INTO tr_para_pihak(prp_id,pgd_id,ktp_nik, kpd_id, prp_no_telp_rumah,prp_no_telp_kantor,prp_no_hp,prp_fax,prp_email,prp_kode_pos,
prp_penyelenggara,prp_organisasi,prp_alamat_org,parpol_id,pp_id,pp_jbp_id,pp_province_id,pp_city_id, flag)

SELECT master_biodata_peradilan.master_biodata_peradilan_id,pengaduan_para_pihak.`pengaduan_id`, master_ktp_nik,master_kategori_pengadu_id,pp_no_telp_rumah,pp_no_telp_kantor,pp_no_seluler,
pp_fax,pp_email,pp_kodepos,pp_penyelenggara,pp_organisasi,pp_alamat_organisasi,master_parpol_id,pp_organisasi_kpu_bawaslu,
pp_organisasi_kpu_bawaslu_jabatan,pp_org_provinsi_id,pp_org_provinsi_id,pengaduan_para_pihak.`flag`
FROM pengaduan_para_pihak
LEFT JOIN pengaduan_detil_para_pihak 
ON pengaduan_detil_para_pihak.`pengaduan_detil_para_pihak_id`=pengaduan_para_pihak.`pengaduan_detil_para_pihak_id`
LEFT JOIN master_biodata_peradilan ON master_biodata_peradilan.`master_biodata_peradilan_id`=pengaduan_detil_para_pihak.`master_biodata_peradilan_id`
WHERE master_biodata_peradilan.`master_biodata_peradilan_id` IS NOT NULL GROUP BY master_biodata_peradilan.`master_biodata_peradilan_id`;

UPDATE tr_para_pihak SET active='Y';

/*QUERY MIGRATE MASTER_UNITKERJA TO MST_UNIT_KERJA*/
INSERT INTO mst_unit_kerja(uk_code,uk_name)
SELECT master_unitkerja_id,master_unitkerja_nama
FROM master_unitkerja;
UPDATE mst_unit_kerja SET active='Y';

/*QUERY MIGRATE MASTER_JABATAN TO MST_JABATAN*/
INSERT INTO mst_jabatan(jabatan_code,jabatan_name,uk_id)
SELECT master_jabatan_id,master_jabatan_nama, mst_unit_kerja.uk_id
FROM master_jabatan LEFT JOIN mst_unit_kerja ON mst_unit_kerja.uk_code=master_jabatan.master_unitkerja_id;
UPDATE mst_jabatan SET active='Y';

/*QUERY MIGRATE KOMISIONER TO TR_KOMISIONER*/
INSERT INTO tr_komisioner(komisioner_id,pg_id,awal_jabatan,akhir_jabatan)
SELECT komisioner.`komisioner_id`,master_biodata_pegawai_id,awal_jabatan,akhir_jabatan
FROM komisioner;
UPDATE tr_komisioner SET active='Y';

/*QUERY MIGRATE VERIFIKATOR TO TR_VERIFIKATOR*/
INSERT INTO tr_verifikator(verifikator_id,pg_id)
SELECT verifikator_id,master_biodata_pegawai_id
FROM view_verifikator;
UPDATE tr_verifikator SET active='Y';

/*QUERY MIGRATE PENGADUAN_TIPE TO MST_TIPE_PENGADUAN*/
INSERT INTO mst_tipe_pengaduan(tp_id,tp_name)
SELECT pengaduan_tipe_id,pengaduan_tipe_nama
FROM pengaduan_tipe;
UPDATE mst_tipe_pengaduan SET active='Y';

/*QUERY MIGRATE PENGADUAN TO MC_PENGADUAN*/
INSERT INTO mc_pengaduan(pgd_id,pgd_no,pgd_format_no,pgd_tempat,pgd_tanggal,tp_id,
kp_id,subdistrict_id,district_id,city_id,province_id, territory_id)
SELECT pengaduan_id,pengaduan_no,pengaduan_format_no, pengaduan_tempat_aduan,pengaduan_tgl_aduan,
pengaduan_tipe_id,pemilu_kategori_id,master_kelurahan_id,master_kecamatan_id,master_kota_kabupaten_id,
master_provinsi_id,master_wilayah_id
FROM pengaduan_ori;
UPDATE mc_pengaduan SET pgd_status='DONE';

/*QUERY MIGRATE PENGADUAN_PROSES TO MC_PENGADUAN_PROSES*/
INSERT INTO mc_pengaduan_proses(pgdproses_id,pgd_id,ps_id)
SELECT pengaduan_proses_id,pengaduan_id,pengaduan_status_id
FROM pengaduan_proses;

/*QUERY MIGRATE PENGADUAN_STATUS TO MST_ALUR_PENGADUAN*/
INSERT INTO mst_alur_pengaduan(ap_id,ap_name)
SELECT pengaduan_status_id,pengaduan_status_nama
FROM pengaduan_status;
UPDATE mst_alur_pengaduan SET active='Y';

/*QUERY MIGRATE PENGADUAN_BUKTI TO MC_PENGADUAN_BUKTI*/
INSERT INTO mc_pengaduan_bukti(pgdb_id,pgd_id,pgdb_keterangan,pgdb_nama_file,flag)
SELECT pengaduan_bukti_id,pengaduan_id,pengaduan_bukti_keterangan,pengaduan_bukti_lampiran_nama,flag
FROM pengaduan_bukti
LEFT JOIN pengaduan_bukti_lampiran ON pengaduan_bukti_lampiran.`pengaduan_bukti_lampiran_id`=pengaduan_bukti.`pengaduan_bukti_lampiran_id`;


/*QUERY MIGRATE PELANGGARAN_LAMPIRAN_TPL_JENIS TO MST_JENIS_LAMPIRAN*/
INSERT INTO mst_jenis_lampiran(jl_id,jl_name,jl_kategori,jl_template)
SELECT pelanggaran_lampiran_tpl_jenis.pelanggaran_lampiran_tpl_jenis_id, pelanggaran_lampiran_tpl_jenis_nama, 
pelanggaran_lampiran_tpl_jenis_kategori, pelanggaran_template_isi
FROM pelanggaran_lampiran_tpl_jenis
LEFT JOIN pelanggaran_template ON pelanggaran_template.`pelanggaran_lampiran_tpl_jenis_id`=pelanggaran_lampiran_tpl_jenis.`pelanggaran_lampiran_tpl_jenis_id`
UPDATE mst_jenis_lampiran SET active='Y';

/*QUERY MIGRATE PENGADUAN_HASIL_PENELITIAN TO MC_PENGADUAN_HASIL_PENELITIAN_ADM*/
INSERT INTO mc_pengaduan_hasil_penelitian_adm(pgdhpa_id,pgd_id,pgdhpa_penerima_pg_id,
pgdhpa_verifikator_pg_id, pgdhpa_tanggal_penelitian,pgdhpa_pokok_pengaduan,pgdhpa_kesimpulan,pgdhpa_keterangan,pgdhpa_kelengkapan_form,
pgdhpa_status_kuasa)
SELECT hasil_penelitian_id,pengaduan_id,penerima_id,verifikator_id,pengaduan_hasil_penelitian_tgl_status,
pengaduan_hasil_penelitian_pokok_pengaduan, penelitian_status_id, pengaduan_hasil_penelitian_keterangan,kelengkapan_form,
surat_kuasa_hukum
FROM pengaduan_hasil_penelitian

UPDATE mc_pengaduan_hasil_penelitian_adm SET created_date=CURRENT_DATE;




