<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use Controller\EmployeeController;
use Repository\EmployeeRepository;
use Model\Employee;

class EmployeeContollerTest extends TestCase {

    // public function test1() {
    //     $repo = new EmployeeRepository();
    //     print_r( (new EmployeeController($repo))->getAllJson() );
    // }

    // public function testGetAllJsonReturnsJson() {
    //     $stub = $this->createStub(EmployeeRepository::class);
    //     $stub->method('getAll')->willReturn(array(new Employee(1, "Jonas"), new Employee(2, "Petras")));
    //     // given
    //     // $employeeRepository = new EmployeeRepository();
    //     $employeeController = new EmployeeController($stub); 
    //     // when
    //     $res = $employeeController->getAllJson();
    //     // then ... turime pakeisti realiais duomenimis iš duomenų bazės!
    //     assertEquals('[{"id":1,"name":"Jonas"},{"id":2,"name":"Petras"}]', $res);
    // }

    
        public function testGetAllJsonReturnsJson() {
            $mock = $this->getMockBuilder(EmployeeRepository::class)->getMock();
            $employeeController = new EmployeeController($mock);
            $mock->expects($this->once())
                ->method('getAll')
                ->willReturn(array(new Employee(1, "Jonas")));
            
            // when
            $res = $employeeController->getAllJson();

            // then
            assertEquals('[{"id":1,"name":"Jonas"}]', $res);
        }
    
        public function testGetAllJsonWithMetaInformationReturnsCorrectResultMock() {
            $mock = $this->getMockBuilder(EmployeeRepository::class)->getMock();
            $employeeController = new EmployeeController($mock);
            $mock->expects($this->exactly(2))
                ->method('getAll')
                ->willReturn(array(new Employee(1, "Jonas")));
            
            // when
            $res = $employeeController->getAllJsonWithMetaInformation();

            // then
            assertEquals('[{"id":1,"name":"Jonas"}], count: 1', $res);
        }

        public function testGetAllJsonWithMetaInformationReturnsCorrectResultStub() {
                $stub = $this->createStub(EmployeeRepository::class);
                $stub->method('getAll')->willReturn(array(new Employee(1, "Jonas"), new Employee(2, "Petras")));
                // given
                // $employeeRepository = new EmployeeRepository();
                $employeeController = new EmployeeController($stub); 
                // when
                $res = $employeeController->getAllJsonWithMetaInformation();
                // then ... turime pakeisti realiais duomenimis iš duomenų bazės!
                assertEquals('[{"id":1,"name":"Jonas"},{"id":2,"name":"Petras"}], count: 2', $res);
            }
}
