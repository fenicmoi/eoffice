                    <table class="table table-bordered table-hover" id="tbRecive">
                        <thead class="bg-info">
                            <tr>
                                <!-- <th>ท/บ กลาง</th>  -->
                                <th>เลขรับ</th>
                                <th>เลขที่เอกสาร</th>
                                <th>เรื่อง</th>
                                <th>จาก</th>
                                <th>วันที่รับ</th>
                                <th>ส่งเอกสาร</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count=1;
                              // $sql="SELECT * FROM  book_master WHERE dep_id=$dep_id  ORDER BY rec_id DESC";
                                $sql="SELECT m.book_id,m.rec_id,d.book_no,d.title,d.sendfrom,d.sendto,d.date_in,d.practice,s.sec_code,r.rec_no
                                      FROM book_master m
                                      INNER JOIN book_detail d ON d.book_id = m.book_id
                                      INNER JOIN section s ON s.sec_id = m.sec_id
                                      INNER JOIN flowrecive r ON r.book_detail_id=d.book_detail_id
                                      WHERE d.practice=$dep_id  AND d.status=1
                                      ORDER BY m.book_id DESC";

                               // echo $sql;
                               $result=dbQuery($sql);
                                $i=0;
                                while($row=  dbFetchArray($result)){?>
                                    <?php $i++; ?>
                                    <?php $rec_id=$row['rec_id']; ?>    <!-- กำหนดตัวแปรเพื่อส่งไปกับลิงค์ -->
                                    <?php $book_id=$row['book_id']; ?>  <!-- กำหนดตัวแปรเพื่อส่งไปกับลิงค์ -->
                                    <tr>
                                    <!-- <td><?php //echo $i; ?></td>  -->
                                    <td><?php  echo $row['rec_no']; ?></td>
                                    <td><?php echo $row['book_no']; ?></td>
                                    <td>
                                        <a href="#" 
                                                onclick="load_leave_data('<? print $u_id;?>','<? print $rec_id; ?>','<? print $book_id; ?>');" data-toggle="modal" data-target=".bs-example-modal-table">
                                                <?php echo $row['title'];?> 
                                        </a>
                                    </td>
                                    <td><?php echo $row['sendto']; ?></td>
                                    <td><?php echo $row['date_in']; ?></td>
                                    <td><a class="btn btn-info" href="paper.php?book_id=<?php echo $book_id ?>"><i  class="fa fa-paper-plane"></i>ส่งหนังสือ</a></td>
                                    </tr>
                                <?php $count++; }?>  
                        </tbody>
                    </table>