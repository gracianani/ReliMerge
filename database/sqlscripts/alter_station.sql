alter table station2ndRecent
add subline_name as 机组名

alter table station2ndRecent
add subline_num as 机组号

alter table station2ndRecent
add second_temperature_out as 供温

alter table station2ndRecent
add second_temperature_in as 回温

alter table station2ndRecent
add second_pressure_out as 供压

alter table station2ndRecent
add second_pressure_in as 回压

alter table station2ndRecent
add heat as 累计热量

alter table station2ndRecent
add water_flow as 累计流量

alter table station2ndRecent
add heat_inst as 瞬时热量

alter table station2ndRecent
add water_flow_inst as 瞬时流量

alter table station2ndRecent
add control_mode as 温度控制模式

alter table station2ndRecent
add station_id as 热力站ID