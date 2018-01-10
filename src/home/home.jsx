import React, { Component } from 'react';
import { Button, Form, FormGroup, Input, Table , InputGroup, InputGroupAddon } from 'reactstrap';
import './home.css';
import myfetch from '../myfetch';


export default class Home extends Component {
    constructor() {
        super();
        this.state = {
            login: '',
            pass: '',
            showTable: false,
            tableData : []
        };
    }

    login = () => {

        let userData = {
            user: this.state.login,
            pass: this.state.pass
        };
        myfetch('auth', userData)
            .then((data) => {
            console.log(data);
                if (data.status == 'success') {
                    this.setState({showTable: true});
                    myfetch('get_shop_data')
                        .then((response) => {
                            this.setState({tableData: response});
                        })
                } else {
                    this.setState({showTable: false});
                    alert(data.status);
                }
            })
    };

    loginStateChange = (e) => { this.setState({login: e.target.value }) };
    passStateChange = (e) => { this.setState({pass: e.target.value }) };

    deleteItem = (idObj) => {
        let item = {
            id: idObj
        };
        myfetch('delete_item', item)
            .then(() =>  myfetch('get_shop_data')
                .then( (rsp) => this.setState({tableData: rsp}) )
            )
    };

    addItem = () => {
        let good =  document.getElementById('goodAdd').value,
            price = document.getElementById('priceAdd').value;

        let item = {
            good : good,
            price : price,
        };

        myfetch('add_item', item)
            .then( (rsp) => myfetch('get_shop_data')
                .then( (rsp) => {
                    this.setState({tableData: rsp});
                    document.getElementById('goodAdd').value = '';
                    document.getElementById('priceAdd').value = '';
                })
            );
    };

    render() {
        return (
            <section>
                { this.state.showTable ? null : <Form>
                    <div className='authorization-form text-center'>
                        <FormGroup>
                            <h4>Please login</h4>
                            <InputGroup>
                                <Input type="text" name='login' value={this.state.login} onChange={this.loginStateChange}/>
                                <InputGroupAddon>Login</InputGroupAddon>
                            </InputGroup>
                        </FormGroup>
                        <FormGroup>
                            <InputGroup>
                                <Input type="text" name='pass' value={this.state.pass} onChange={this.passStateChange}/>
                                <InputGroupAddon>Password</InputGroupAddon>
                            </InputGroup>
                        </FormGroup>
                        <Button color="success" onClick={()=> this.login()}>Login</Button>
                    </div>
                </Form> }
                {this.state.showTable ? <TableUsers data={this.state.tableData} del={this.deleteItem} addI={this.addItem}/> : null}
            </section>
        )
    }
}

let TableUsers = (props) => {

    return (
        <Table>
            <thead>
                <tr>
                    <td>Goods</td>
                    <td>Price</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                {props.data.map((item) =>
                    <tr key={item.idwallDB}>
                        <td>{item.good}</td>
                        <td>{item.price}</td>
                        <td><Button color='danger' onClick={ ()=>props.del(item.idwallDB) } >Del</Button></td>
                    </tr>
                )}
                <tr>
                    <td>
                        <Input type="text" name='goodAdd' id='goodAdd' placeholder='good'/>
                    </td>
                    <td>
                        <Input type="text" name='priceAdd' id='priceAdd' placeholder='price'/>
                    </td>
                    <td>
                        <Button color='success'  onClick={ ()=>props.addI() }>Add</Button>
                    </td>
                </tr>
            </tbody>
        </Table>
    )
};

