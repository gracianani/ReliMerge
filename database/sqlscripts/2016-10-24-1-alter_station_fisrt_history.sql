
alter table station1stHistory
add stationId as 热力站ID

alter table station1stHistory
add date as 时间

alter table station1stHistory
add first_temperature_out as 一次供温

alter table station1stHistory
add first_temperature_in as 一次回温

alter table station1stHistory
add first_pressure_out as 一次供压

alter table station1stHistory
add first_pressure_in as 一次回压

alter table station1stHistory
add total_heat as 总累计热量

alter table station1stHistory
add total_water_flow as 总累计流量

alter table station1stHistory
add total_water_flow_inst as 总瞬时流量

alter table station1stHistory
add total_heat_inst as 总瞬时热量

alter table station1stHistory
add heat_index_actual as 实际热指标

alter table station1stHistory
add flow_ten_thou as 万平方米流量

alter table station1stHistory
add water_meter as 水表