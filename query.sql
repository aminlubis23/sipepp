/*Query for view history pengaduan*/
SELECT
     GROUP_CONCAT(CONCAT('-',`mst_alur_pengaduan`.`ap_name`) SEPARATOR ':')
   FROM (`mc_pengaduan_proses`
      LEFT JOIN `mst_alur_pengaduan`
        ON ((`mst_alur_pengaduan`.`ap_id` = `mc_pengaduan_proses`.`ap_id`)))
   WHERE (`mc_pengaduan_proses`.`pgd_id` = `mc_pengaduan`.`pgd_id`)
   GROUP BY `mc_pengaduan_proses`.`pgd_id`