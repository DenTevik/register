<?php

namespace models;

use Core\Database;

class Statistic
{
    protected Database $db;
    protected const BED_PRICE = 30;
    protected const TOWELS_PRICE = 10;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getUserMonthStats($userId, $month): array
    {
        $data = [];

        // get stats
        $stats = $this->db->query(
            "SELECT s.id, u.name, r.build, r.type, b.hotel, p.price,
                    DATE_FORMAT(s.start, '%Y-%m-%d') as thedate,
                    COUNT(CASE WHEN s.work = '1' THEN 1 END) as zaezd, 
                    COUNT(CASE WHEN s.work = '2' THEN 1 END) as generalnaya, 
                    COUNT(CASE WHEN s.work = '3' THEN 1 END) as tekuchka,
                    SUM(s.bed) as bed_count,
                    SUM(s.towels) as towels_count,
                    SUM(p.price) as day_price,
                    substring_index(GROUP_CONCAT(CONCAT(s.work,';',s.start,';',s.end) ORDER BY s.start ASC SEPARATOR ','), ',', 1) as start_end
                    FROM statistics s
                      LEFT JOIN users u ON (u.id = s.staff)
                      LEFT JOIN rooms r ON (r.id = s.room)
                      LEFT JOIN builds b ON (b.id = r.build)
                      LEFT JOIN prices p ON (p.hotel = b.hotel AND p.room_type = r.type AND s.work = p.work)
                    WHERE s.staff = :userId
                    GROUP BY thedate, test_staff.s.id, test_staff.p.price",
            ['userId' => $userId]
        )->get();

        foreach ($stats as $stat) {
            $data[$stat->thedate]['date'] = $stat->thedate;
            $startEnd = explode(';', $stat->start_end);
            if ((int) $startEnd[0] === 0) {
                $data[$stat->thedate]['start'] = $startEnd[1];
                $data[$stat->thedate]['end'] = $startEnd[2];
            }
            $data[$stat->thedate]['work']['Генеральная'] = $data[$stat->thedate]['work']['Генеральная'] ?? 0;
            $data[$stat->thedate]['work']['Текущая'] = $data[$stat->thedate]['work']['Текущая'] ?? 0;
            $data[$stat->thedate]['work']['Заезд'] = $data[$stat->thedate]['work']['Заезд'] ?? 0;
            $data[$stat->thedate]['work']['Генеральная'] += $stat->generalnaya;
            $data[$stat->thedate]['work']['Текущая'] += $stat->tekuchka;
            $data[$stat->thedate]['work']['Заезд'] += $stat->zaezd;
            $data[$stat->thedate]['price'] = $data[$stat->thedate]['price'] ?? 0;
            $data[$stat->thedate]['price'] += $stat->day_price;
            $data[$stat->thedate]['price'] += $stat->bed_count * self::BED_PRICE;
            $data[$stat->thedate]['price'] += $stat->towels_count * self::TOWELS_PRICE;
        }

        return $data;
    }

    public function getUserDayStats($userId, $date)
    {
        $data = [];
        $stats = $this->db->query(
            "SELECT s.id, u.name, r.num as room_num, r.type as room_type, b.name as room_korpus, s.bed, s.towels, p.price, s.start as clean_start, s.end as clean_end, w.name as work_name,
            IF(s.work = '0', s.start, '-') as start_day,
            IF(s.work = '0', s.end, '-') as start_end
            FROM statistics s
              LEFT JOIN users u ON (u.id = s.staff)
              LEFT JOIN works w ON (w.id = s.work)
              LEFT JOIN rooms r ON (r.id = s.room)
              LEFT JOIN builds b ON (b.id = r.build)
              LEFT JOIN prices p ON (p.hotel = b.hotel AND p.room_type = r.type AND s.work = p.work)
              WHERE s.staff = :userId
            AND s.work != 0
            AND s.start between :date_from and :date_to
            ORDER BY clean_start ASC",
            ['userId' => $userId, 'date_from' => $date .' 00:00:00', 'date_to' => $date. ' 23:59:59']
        )->get();

        foreach ($stats as $stat) {
            $data[$stat->id] = $stat;
            $data[$stat->id]->price += ($stat->bed * self::BED_PRICE);
            $data[$stat->id]->price += ($stat->towels * self::TOWELS_PRICE);
        }

        return $stats;
    }
}
