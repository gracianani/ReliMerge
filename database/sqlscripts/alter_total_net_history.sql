alter table totalnethistory 
add total_area_in_use_planned as 计划供热面积

alter table totalnethistory 
add total_area_in_use_actual as 实际供热面积

alter table totalnethistory 
add total_area_out_of_service_planned as 总面积-计划供热面积

alter table totalnethistory 
add total_area_out_of_service_actual as 总面积-实际供热面积

alter table totalnethistory 
add area_planned as 今日计划Area

alter table totalnethistory 
add area_actual as 今日投入Area